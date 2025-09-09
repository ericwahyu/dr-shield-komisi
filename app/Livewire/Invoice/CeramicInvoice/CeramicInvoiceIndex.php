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
use App\Traits\CommissionProcess;
use App\Traits\CommissionProcess\CeramicCommissionProsses;
use App\Traits\GetSystemSetting;
use App\Traits\InvoiceProcess;
use App\Traits\InvoiceProcess\CeramicInvoiceProsses;
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
    use LivewireAlert, WithPagination, GetSystemSetting, WithFileUploads, CeramicInvoiceProsses, CeramicCommissionProsses;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10, $search;

    public $filter_month, $filter_sales;
    public $due_date_ceramic_rules;
    public $get_invoice, $id_data, $sales_id, $sales_code, $date, $invoice_number, $customer, $id_customer, $due_date, $income_tax, $value_tax, $amount;
    public $file_import;
    public $categories;

    public function render()
    {
        $ceramic_invoices = Invoice::search($this->search);

        return view('livewire.invoice.ceramic-invoice.ceramic-invoice-index', [
            'sales' => User::role('sales')->whereHas('userDetail', function ($query) {
                    $query->where('sales_type', 'ceramic');
                })->get(),

            'list_primary' => User::role('sales')->whereHas('userDetail', function ($query) {
                $query->where('sales_type', 'ceramic');
            })->search($this->sales_primary)->get(),

            'list_secondary' => User::role('sales')->whereHas('userDetail', function ($query) {
                $query->where('sales_type', 'ceramic');
            })->search($this->sales_secondary)->get(),

            'ceramic_invoices' => $ceramic_invoices->where('type', 'ceramic')
                ->when($this->filter_sales, function ($query) {
                    $query->where('user_id', $this->filter_sales);
                })
                ->when($this->filter_month, function ($query) {
                    $query->whereYear('date', (int)Carbon::parse($this->filter_month)->format('Y'))->whereMonth('date', (int)Carbon::parse($this->filter_month)->format('m'));
                })->withSum(['paymentDetails' => function ($query) {
                    $query->where('version', 1);
                }], 'income_tax')
                ->paginate($this->perPage),
        ])->extends('layouts.layout.app')->section('content');
    }

    public function mount()
    {
        $this->due_date_ceramic_rules = DueDateRuleCeramic::where('type', 'ceramic')->where('version', 1)->orderBy('due_date', 'ASC')->get();
        $this->categories             = Category::where('type', 'ceramic')->where('version', 1)->get();
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->clearSecondary();
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
        // if (count($this->categories) > 0 ) {
        //     foreach ($this->categories as $key => $category) {
        //         $check_lower_limit = User::find($this->sales_id)->lowerLimits()->whereHas('category', fn ($query) => $query->where('id', $category?->id))->where('version', 1)->first();
        //         if (!$check_lower_limit) {
        //             return $this->alert('warning', 'Peringatan', [
        //                 'text' => "Data target batas bawah untuk $category?->name belum diatur !"
        //             ]);
        //         }
        //     }
        // } else {
        //     $check_lower_limit = User::find($this->sales_id)->lowerLimits()->whereNull('category_id')->where('version', 1)->first();
        //     if (!$check_lower_limit) {
        //         return $this->alert('warning', 'Peringatan', [
        //             'text' => 'Data target batas bawah belum diatur !'
        //         ]);
        //     }
        // }

        $this->validate([
            'sales_id'       => 'required',
            'date'           => 'required|date',
            'invoice_number' => 'required',
            'customer'       => 'required',
            'id_customer'    => 'nullable',
            'due_date'       => 'required|numeric',
            'income_tax'     => 'required|numeric',
            'value_tax'      => 'required|numeric',
            'amount'         => 'required|numeric',
        ]);

        $unique_invoice = Invoice::where('invoice_number', $this->invoice_number)->first();

        if ($unique_invoice && $this->id_data == null) {
            return $this->alert('warning', 'Maaf', [
                'text' => 'Nomor Faktur sudah ada pada database!'
            ]);
        }

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
                        'category_id' => null,
                        'version'     => 1,
                    ],
                    [
                       'category_id' => null,
                       'version'     => 1,
                       'income_tax'  => intval(Str::replace('.','',$this->income_tax)),
                       'value_tax'   => intval(Str::replace('.','',$this->value_tax)),
                       'amount'      => intval(Str::replace('.','',$this->amount)),
                    ]
                );

                $invoice->paymentDetails()->updateOrCreate(
                    [
                        'category_id' => null,
                        'version'     => 2,
                    ],
                    [
                       'category_id' => null,
                       'version'     => 2,
                       'income_tax'  => intval(Str::replace('.','',$this->income_tax)),
                       'value_tax'   => intval(Str::replace('.','',$this->value_tax)),
                       'amount'      => intval(Str::replace('.','',$this->amount)),
                    ]
                );

                //proses invoice
                $datas = array(
                    'due_date' => $this->due_date,
                    'version'  => 1,
                );
                $this->_ceramicInvoice($invoice, $datas);

                $datas = array(
                    'due_date' => $this->due_date,
                    'version'  => 2,
                );
                $this->_ceramicInvoice($invoice, $datas);

                //create commission
                $datas = array(
                    'income_tax' => $this->income_tax,
                    'version'    => 1,
                );
                $this->_ceramicCommission($invoice, $datas);

                $datas = array(
                    'income_tax' => $this->income_tax,
                    'version'    => 2,
                );
                $this->_ceramicCommission($invoice, $datas);

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
        $this->sales_code     = User::find($this->sales_id) ? User::find($this->sales_id)?->userDetail?->sales_code : null;
        $this->date           = $this->get_invoice?->date?->format('Y-m-d');
        $this->invoice_number = $this->get_invoice?->invoice_number;
        $this->customer       = $this->get_invoice?->customer;
        $this->id_customer    = $this->get_invoice?->id_customer;
        $this->due_date       = $this->get_invoice?->due_date;
        $this->income_tax     = $this->get_invoice?->income_tax;
        $this->value_tax      = $this->get_invoice?->value_tax;
        $this->amount         = $this->get_invoice?->amount;

        $this->selectSecondary($this->sales_id);

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
                $invoice = $result;
                $result->invoiceDetails()->delete();
                $result->paymentDetails()->delete();
                $result->dueDateRules()->delete();
                $result?->delete();

                $datas = array(
                    'income_tax' => $invoice?->income_tax,
                    'version'    => 1,
                );
                $this->_ceramicCommission($invoice, $datas);

                $datas = array(
                    'income_tax' => $invoice?->income_tax,
                    'version'    => 2,
                );
                $this->_ceramicCommission($invoice, $datas);

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

        try {
            Excel::import(new CeramicInvoiceImport, $this->file_import);
        } catch (Exception | Throwable $th) {
            Log::error($th->getMessage());
            Log::error("Ada kesalahan saat Import data faktur keramik");
            $this->closeModal();

            return $this->alert('error', 'Gagal', [
                'text' => 'Ada kesalahan saat Import data faktur keramik !'
            ]);
        }

        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Faktur Keramik berhasil disimpan !, silahkan tunggu beberapa saat'
        ]);
    }

    public function sumIncomeTax($version)
    {
        return Invoice::search($this->search)->where('type', 'ceramic')
            ->when($this->filter_sales, function ($query) {
                $query->where('user_id', $this->filter_sales);
            })
            ->when($this->filter_month, function ($query) {
                $query->whereYear('date', (int)Carbon::parse($this->filter_month)->format('Y'))->whereMonth('date', (int)Carbon::parse($this->filter_month)->format('m'));
            })->withSum(['paymentDetails' => function ($query) use ($version) {
                $query->where('version', $version);
            }], 'income_tax')->get()->sum('payment_details_sum_income_tax');
    }

    // Sales utama
    public $sales_primary;
    public $selected_sales_primary;
    public $open_sales_primary = false;

    // Sales pendamping
    public $sales_secondary;
    public $selected_sales_secondary;
    public $open_sales_secondary = false;

    public function selectPrimary($id)
    {
        $this->selected_sales_primary = User::find($id);
        $this->filter_sales = $this->selected_sales_primary?->id;
        $this->sales_primary = $this->selected_sales_primary?->name;
    }

    public function clearPrimary()
    {
        $this->selected_sales_primary = null;
        $this->filter_sales = null;
        $this->sales_primary = '';
    }

    public function selectSecondary($id)
    {
        $this->selected_sales_secondary = User::find($id);
        $this->sales_id = $this->selected_sales_secondary?->id;
        $this->sales_secondary = $this->selected_sales_secondary?->name;
        $this->sales_code = User::find($this->sales_id) ? User::find($this->sales_id)?->userDetail?->sales_code : null;
    }

    public function clearSecondary()
    {
        $this->selected_sales_secondary = null;
        $this->sales_id = null;
        $this->sales_code = null;
        $this->sales_secondary = '';
    }
}
