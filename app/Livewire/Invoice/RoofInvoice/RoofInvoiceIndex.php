<?php

namespace App\Livewire\Invoice\RoofInvoice;

use App\Models\Auth\User;
use App\Models\Commission\Commission;
use App\Models\Invoice\Invoice;
use App\Models\Invoice\PaymentDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class RoofInvoiceIndex extends Component
{
    use LivewireAlert, WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10, $search;

    public $filter_month, $filter_sales;
    public $data_due_dates;
    public $get_invoice, $id_data, $sales_id, $sales_code, $date, $invoice_number, $customer, $id_customer, $due_date, $income_tax, $value_tax, $amount;
    public $income_tax_shield, $value_tax_shield, $amount_shield, $income_tax_sonne, $value_tax_sonne, $amount_sonne;

    public function render()
    {
        return view('livewire.invoice.roof-invoice.roof-invoice-index', [
            'sales' => User::role('sales')->whereHas('userDetail', function ($query) {
                    $query->where('sales_type', 'roof');
                })->get(),

            'roof_invoices' => Invoice::where('type', 'roof')
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
        $this->data_due_dates = [
            [
                'due_date' => 0,
                'value'    => 100,
            ],
            [
                'due_date' => 15,
                'value'    => 50,
            ],
            [
                'due_date' => 7,
                'value'    => 0,
            ],
        ];
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->reset('get_invoice', 'id_data', 'sales_id', 'sales_code', 'date', 'invoice_number', 'customer', 'id_customer', 'due_date', 'income_tax_shield', 'value_tax_shield', 'amount_shield', 'income_tax_sonne', 'value_tax_sonne', 'amount_sonne', 'income_tax', 'value_tax', 'amount');
        $this->dispatch('closeModal');
    }

    public function updated()
    {
        if ($this->sales_id) {
            $this->sales_code = User::find($this->sales_id) ? User::find($this->sales_id)?->userDetail?->sales_code : null;
        }

        if ($this->income_tax_shield) {
            $this->value_tax_shield = (int)$this->income_tax_shield * 0.11;
            $this->amount_shield    = (int)$this->income_tax_shield + (int)$this->value_tax_shield;
        }

        if ($this->income_tax_sonne) {
            $this->value_tax_sonne = (int)$this->income_tax_sonne * 0.11;
            $this->amount_sonne    = (int)$this->income_tax_sonne + (int)$this->value_tax_sonne;
        }

        $this->income_tax = (double)$this->income_tax_shield + (double)$this->income_tax_sonne;
        $this->value_tax  = (double)$this->value_tax_shield + (double)$this->value_tax_sonne;
        $this->amount     = (double)$this->amount_shield + (double)$this->amount_sonne;
    }

    public function saveData()
    {
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
                        'type'           => 'roof',
                        'date'           => $this->date,
                        'invoice_number' => $this->invoice_number,
                        'customer'       => $this->customer,
                        'id_customer'    => $this->id_customer,
                        'income_tax'     => (int)number_format($this->income_tax, 0, ',', ''),
                        'value_tax'      => (int)number_format($this->value_tax, 0, ',', ''),
                        'amount'         => (int)number_format($this->amount, 0, ',', ''),
                        'due_date'       => $this->due_date,
                    ]
                );

                $invoice->paymentDetails()->updateOrCreate(
                    [
                        'category' => 'dr-shield'
                    ],
                    [
                        'income_tax'     => (int)number_format($this->income_tax_shield, 0, ',', ''),
                        'value_tax'      => (int)number_format($this->value_tax_shield, 0, ',', ''),
                        'amount'         => (int)number_format($this->amount_shield, 0, ',', ''),
                    ]
                );

                $invoice->paymentDetails()->updateOrCreate(
                    [
                        'category' => 'dr-sonne'
                    ],
                    [
                        'income_tax'     => (int)number_format($this->income_tax_sonne, 0, ',', ''),
                        'value_tax'      => (int)number_format($this->value_tax_sonne, 0, ',', ''),
                        'amount'         => (int)number_format($this->amount_sonne, 0, ',', ''),
                    ]
                );

                if ($this->id_data == null) {
                    $this->createDueDateRule($invoice);

                } elseif ($this?->get_invoice?->due_date != $this->due_date || $this->get_invoice?->date != $this->date) {
                    $invoice->dueDateRules()->delete();
                    $this->createDueDateRule($invoice);
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

                $this->createCommission($invoice, 'dr-shield');
                $this->createCommission($invoice, 'dr-sonne');
            });
        } catch (Exception | Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
            Log::error("Terjadi Kesalahan Saat Menyimpan Data Faktur Atap!");

            return $this->alert('error', 'Maaf', [
                'text' => 'Terjadi Kesalahan Saat Menyimpan Data Faktur Atap !'
            ]);
        }
        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Faktur Atap Telah Disimpan !'
        ]);
    }

    private function createDueDateRule($invoice)
    {
        foreach ($this->data_due_dates as $key => $data_due_date) {
            if ($key == 0) {
                $invoice->dueDateRules()->create(
                    [
                        'type'     => 'roof',
                        'number'   => $key,
                        'due_date' => $data_due_date['due_date'],
                        'value'    => $data_due_date['value'],
                    ]
                );
            } elseif ($key == 1) {
                $invoice->dueDateRules()->create(
                    [
                        'type'     => 'roof',
                        'number'   => $key,
                        'due_date' => $this?->due_date <= 30 ? 30 + (int)$data_due_date['due_date'] : (int)$this?->due_date + (int)$data_due_date['due_date'],
                        'value'    => $data_due_date['value'],
                    ]
                );
            } elseif ($key > 1) {
                $get_due_date_rule = $invoice->dueDateRules()->orderBy('number', 'DESC')->first();
                $invoice->dueDateRules()->create(
                    [
                        'type'     => 'roof',
                        'number'   => $key,
                        'due_date' => (int)$get_due_date_rule?->due_date + (int)$data_due_date['due_date'],
                        'value'    => $data_due_date['value'],
                    ]
                );
            }
        }
    }

    private function createCommission($invoice, $category)
    {
        //create commission
        $get_commission = Commission::where('user_id', $this->sales_id)->where('month', (int)$invoice?->date?->format('m'))->where('year', (int)$invoice?->date?->format('Y'))->where('category', $category)->first();
        if (!$get_commission) {
            $commission = Commission::create([
                'user_id'     => $this->sales_id,
                'month'       => $invoice?->date?->format('m'),
                'year'        => $invoice?->date?->format('Y'),
                'category'    => $category,
                'total_sales' => $category == 'dr-shield' ? $this->income_tax_shield : ($category == 'dr-sonne' ? $this->income_tax_sonne : null),
                'status'      => 'not-reach'
            ]);

            if (count($commission->lowerLimitCommissions) == 0) {
                $lower_limit_ceramics = User::find($this->sales_id)->lowerLimits()->where('category', $category)->get();
                foreach ($lower_limit_ceramics as $key => $lower_limit_ceramic) {
                    $commission->lowerLimitCommissions()->create([
                        'lower_limit_id' => $lower_limit_ceramic?->id,
                        'category'       => $category,
                        'target_payment' => $lower_limit_ceramic?->target_payment,
                        'value'          => $lower_limit_ceramic?->value,
                    ]);
                }
            }
        } else {
            $sum_income_tax = PaymentDetail::whereHas('invoice', function ($query) use ($invoice) {
                $query->whereHas('user', function ($query) {
                    $query->where('id', $this->sales_id);
                })->whereYear('date', (int)$invoice?->date->format('Y'))->whereMonth('date', (int)$invoice?->date->format('m'))->where('type', 'roof');
            })->where('category', $category)->sum('income_tax');

            $get_commission?->update([
                'total_sales' => $sum_income_tax,
            ]);
        }
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
                'text' => 'Terjadi Kesalahan Saat Menghapus Data Faktur Atap!'
            ]);
        }

        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Faktur Atap Telah Dihapus !'
        ]);
    }
}
