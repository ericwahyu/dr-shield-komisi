<?php

namespace App\Livewire\Invoice\CeramicInvoice;

use App\Imports\Invoice\CeramicInvoice\CeramicInvoiceImport;
use App\Models\Auth\User;
use App\Models\Commission\Commission;
use App\Models\Commission\LowerLimit;
use App\Models\Invoice\DueDateRule;
use App\Models\Invoice\DueDateRuleCeramic;
use App\Models\Invoice\Invoice;
use App\Models\Invoice\InvoiceDetail;
use App\Models\System\Category;
use App\Traits\GetSystemSetting;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class CeramicInvoiceIndex extends Component
{
    use LivewireAlert, WithPagination, GetSystemSetting, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10, $search;

    public $filter_month, $filter_sales;
    public $due_date_ceramic_rules;
    public $get_invoice, $id_data, $sales_id, $sales_code, $date, $invoice_number, $customer, $id_customer, $due_date, $income_tax, $value_tax, $amount;
    public $file_import;
    public $categories;

    public function render()
    {
        return view('livewire.invoice.ceramic-invoice.ceramic-invoice-index', [
            'sales' => User::role('sales')->whereHas('userDetail', function ($query) {
                    $query->where('sales_type', 'ceramic');
                })->get(),

            'ceramic_invoices' => Invoice::where('type', 'ceramic')
                ->when($this->filter_sales, function ($query) {
                    $query->where('user_id', $this->filter_sales);
                })
                ->when($this->filter_month, function ($query) {
                    $query->whereYear('date', (int)Carbon::parse($this->filter_month)->format('Y'))->whereMonth('date', (int)Carbon::parse($this->filter_month)->format('m'));
                })
                ->paginate($this->perPage),
        ])->extends('layouts.layout.app')->section('content');
    }

    public function mount()
    {
        $this->due_date_ceramic_rules = DueDateRuleCeramic::where('type', 'ceramic')->orderBy('due_date', 'ASC')->get();
        $this->categories             = Category::where('type', 'ceramic')->get();
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->reset('get_invoice', 'id_data', 'sales_id', 'sales_code', 'date', 'invoice_number', 'customer', 'id_customer', 'due_date', 'income_tax', 'value_tax', 'amount', 'file_import');
        $this->dispatch('closeModal');
    }

    public function updated()
    {
        if ($this->sales_id) {
            $this->sales_code = User::find($this->sales_id) ? User::find($this->sales_id)?->userDetail?->sales_code : null;
        }

        if ($this->income_tax) {
            // dd('ubah');
            $this->value_tax = round((int)$this->income_tax * 0.11);
            $this->amount    = (int)$this->income_tax + (int)$this->value_tax;
        }
    }

    public function saveData()
    {
        if (count($this->categories) > 0 ) {
            foreach ($this->categories as $key => $category) {
                $check_lower_limit = User::find($this->sales_id)->lowerLimits()->whereHas('category', fn ($query) => $query->where('id', $category?->id))->first();
                if (!$check_lower_limit) {
                    return $this->alert('warning', 'Peringatan', [
                        'text' => "Data target batas bawah untuk $category?->name belum diatur !"
                    ]);
                }
            }
        } else {
            $check_lower_limit = User::find($this->sales_id)->lowerLimits()->whereNull('category_id')->first();
            if (!$check_lower_limit) {
                return $this->alert('warning', 'Peringatan', [
                    'text' => 'Data target batas bawah belum diatur !'
                ]);
            }
        }

        $this->validate([
            'sales_id'       => 'required',
            'date'           => 'required|date',
            'invoice_number' => 'required',
            'customer'       => 'required',
            'id_customer'    => 'required',
            'due_date'       => 'required|numeric',
            'income_tax'     => 'required|numeric',
            'value_tax'      => 'required|numeric',
            'amount'         => 'required|numeric',
        ]);

        try {
            DB::transaction(function () {
                $invoice = Invoice::updateOrCreate(
                    [
                        'id' => $this->id_data
                    ],
                    [
                        'user_id'        => $this->sales_id,
                        'type'           => 'ceramic',
                        'date'           => $this->date,
                        'invoice_number' => $this->invoice_number,
                        'customer'       => $this->customer,
                        'id_customer'    => $this->id_customer,
                        'income_tax'     => intval(Str::replace('.','',$this->income_tax)),
                        'value_tax'      => intval(Str::replace('.','',$this->value_tax)),
                        'amount'         => intval(Str::replace('.','',$this->amount)),
                        'due_date'       => $this->due_date,
                    ]
                );

                $invoice->paymentDetails()->updateOrCreate(
                    [
                        'category_id' => null
                    ],
                    [
                       'category_id' => null,
                       'income_tax'  => intval(Str::replace('.','',$this->income_tax)),
                       'value_tax'   => intval(Str::replace('.','',$this->value_tax)),
                       'amount'      => intval(Str::replace('.','',$this->amount)),
                    ]
                );

                if ($this->id_data == null) {
                    foreach ($this->due_date_ceramic_rules as $key => $due_date_ceramic_rule) {
                        $invoice->dueDateRules()->create(
                            [
                                'number'   => $key,
                                'due_date' => $due_date_ceramic_rule?->due_date,
                                'value'    => $due_date_ceramic_rule?->value,
                            ]
                        );
                    }
                } elseif ($this->get_invoice?->date != $this->date) {
                    // $invoice->invoiceDetails()->delete();
                    foreach ($invoice?->invoiceDetails as $key => $invoice_detail) {

                        $percentage = null;
                        $get_diffDay    = Carbon::parse($invoice?->date)->diffInDays($invoice_detail?->date);
                        $desc_due_dates = $invoice->dueDateRules()->orderBy('due_date', 'DESC')->get();

                        if (Carbon::parse($invoice_detail?->date)->toDateString() <= Carbon::parse($invoice?->date)->toDateString()) {
                            $percentage = 100;
                        } else {
                            foreach ($desc_due_dates as $key => $desc_due_date) {
                                if ((int)$get_diffDay >= (int)$desc_due_date?->due_date) {
                                    $percentage = $desc_due_date?->value;
                                    break;
                                }
                            }
                        }

                        $invoice->invoiceDetails()->where('id', $invoice_detail?->id)->first()?->update([
                            'percentage' => $percentage
                        ]);
                    }
                }

                //create commission
                $get_commission = Commission::where('user_id', $this->sales_id)->where('month', (int)$invoice?->date?->format('m'))->where('year', (int)$invoice?->date?->format('Y'))->whereNull('category_id')->first();
                if (!$get_commission) {
                    $commission = Commission::create([
                        'user_id'    => $this->sales_id,
                        'month'      => $invoice?->date?->format('m'),
                        'year'       => $invoice?->date?->format('Y'),
                        'income_tax' => intval(Str::replace('.','',$this->income_tax)),
                        'status'     => 'not-reach'
                    ]);

                    if (count($commission->lowerLimitCommissions) == 0) {
                        $lower_limit_ceramics = User::find($this->sales_id)->lowerLimits()->whereNull('category_id')->get();
                        foreach ($lower_limit_ceramics as $key => $lower_limit_ceramic) {
                            $commission->lowerLimitCommissions()->create([
                                'lower_limit_id' => $lower_limit_ceramic?->id,
                                'target_payment' => $lower_limit_ceramic?->target_payment,
                                'value'          => $lower_limit_ceramic?->value,
                            ]);
                        }
                    }
                } else {
                    $sum_income_tax = Invoice::whereHas('user', function ($query) {
                        $query->where('id', $this->sales_id);
                    })->whereYear('date', (int)$invoice?->date->format('Y'))->whereMonth('date', (int)$invoice?->date->format('m'))->where('type', 'ceramic')->sum('income_tax');

                    // $total_income = InvoiceDetail::whereHas('invoice', function ($query) use ($category) {
                    //     $query->whereYear('date', (int)$this->get_invoice?->date?->format('Y'))->whereMonth('date', (int)$this->get_invoice?->date?->format('m'))->where('user_id', $this->get_invoice?->user?->id)->where('category_id', null);
                    // })->whereYear('date', (int)Carbon::parse($year_month_invoice_detail)->format('Y'))->whereMonth('date', (int)Carbon::parse($year_month_invoice_detail)->format('m'))->where('percentage', (int)$percentage_invoice_details)->sum('amount');

                    $get_lower_limit_commission = $get_commission?->lowerLimitCommissions()->whereNull('category_id')->where('target_payment', '<=', (int)$sum_income_tax)->max('value');
                    $get_lower_limit_commission = $get_lower_limit_commission != null && $get_lower_limit_commission >= 0.3 ? $get_lower_limit_commission + $this->getSystemSetting()?->value_incentive : $get_lower_limit_commission;

                    $get_commission?->update([
                        'total_sales'                 => $sum_income_tax,
                        'percentage_value_commission' => $get_lower_limit_commission,
                        'status'                      => $get_lower_limit_commission != null ? 'reached' : 'not-reach'
                    ]);

                    if ($get_commission?->percentage_value_commission != null) {
                        foreach ($get_commission?->commissionDetails()->get() as $key => $commission_detail) {
                            $commission_detail->update([
                                'value_of_due_date' => $commission_detail?->total_income * ($get_commission?->percentage_value_commission/100)
                            ]);
                        }
                    }
                }
            });
        } catch (Exception | Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
            Log::error("Terjadi Kesalahan Saat Menyimpan Data Faktur Keramik!");

            return $this->alert('error', 'Maaf', [
                'text' => 'Terjadi Kesalahan Saat Menyimpan Data Faktur Keramik !'
            ]);
        }
        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Faktur Keramik Telah Disimpan !'
        ]);
    }

    public function edit($id)
    {
        $this->get_invoice    = Invoice::find($id);
        $this->id_data        = $this->get_invoice?->id;
        $this->sales_id       = $this->get_invoice?->user?->id;
        $this->date           = $this->get_invoice?->date?->format('Y-m-d');
        $this->invoice_number = $this->get_invoice?->invoice_number;
        $this->customer       = $this->get_invoice?->customer;
        $this->id_customer    = $this->get_invoice?->id_customer;
        $this->due_date       = $this->get_invoice?->due_date;
        $this->income_tax     = $this->get_invoice?->income_tax;
        $this->value_tax      = $this->get_invoice?->value_tax;
        $this->amount         = $this->get_invoice?->amount;

        $this->dispatch('openModal');
    }

    public function deleteConfirm($id)
    {
        $this->confirm('Konfirmasi', [
            'inputAttributes'    => ['id' => $id],
            'onConfirmed'        => 'delete',
            'text'               => 'Data yang dihapus tidak dapat di kembalikan lagi',
            'reverseButtons'     => 'true',
            'confirmButtonColor' => '#24B464',
        ]);
    }

    public function getListeners()
    {
        return ['delete'];
    }

    public function delete($data)
    {
        try {
            DB::transaction(function () use ($data) {
                $result = Invoice::find($data['inputAttributes']['id']);
                $result?->delete();
            });

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return $this->alert('error', 'Maaf', [
                'text' => 'Terjadi Kesalahan Saat Menghapus Data Faktur Keramik!'
            ]);
        }

        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Faktur Keramik Telah Dihapus !'
        ]);
    }

    public function importInvoiceData()
    {
        $this->validate([
            'file_import' => 'required|file|mimes:xlsx',
        ]);

        Excel::import(new CeramicInvoiceImport, $this->file_import);

        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Faktur Keramik berhasil disimpan !'
        ]);
    }
}
