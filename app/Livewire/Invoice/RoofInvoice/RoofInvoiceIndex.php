<?php

namespace App\Livewire\Invoice\RoofInvoice;

use App\Imports\Invoice\RoofInvoice\RoofInvoiceImport;
use App\Models\Auth\User;
use App\Models\Commission\Commission;
use App\Models\Invoice\Invoice;
use App\Models\Invoice\PaymentDetail;
use App\Models\System\Category;
use App\Traits\CommissionProcess;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class RoofInvoiceIndex extends Component
{
    use LivewireAlert, WithPagination, WithFileUploads, CommissionProcess;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10, $search;

    public $filter_month, $filter_sales;
    public $data_due_dates;
    public $get_invoice, $id_data, $sales_id, $sales_code, $date, $invoice_number, $customer, $id_customer, $due_date;
    public $income_tax = 0, $value_tax = 0, $amount = 0;
    public $income_taxs = [], $value_taxs = [], $amounts = [];
    public $file_import;
    public $categories;

    public function render()
    {
        $roof_invoices = Invoice::search($this->search);
        return view('livewire.invoice.roof-invoice.roof-invoice-index', [
            'sales' => User::role('sales')->whereHas('userDetail', function ($query) {
                    $query->where('sales_type', 'roof');
                })->get(),

            'roof_invoices' => $roof_invoices->where('type', 'roof')
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

        $this->categories = Category::where('type', 'roof')->get();
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->reset('get_invoice', 'id_data', 'sales_id', 'sales_code', 'date', 'invoice_number', 'customer', 'id_customer', 'due_date', 'income_taxs', 'value_taxs', 'amounts', 'income_tax', 'value_tax', 'amount', 'file_import');
        $this->dispatch('closeModal');
    }

    public function updated()
    {
        if ($this->sales_id) {
            $this->sales_code = User::find($this->sales_id) ? User::find($this->sales_id)?->userDetail?->sales_code : null;
        }

        foreach ($this->categories as $key => $category) {
            if (isset($this->income_taxs[$category?->slug])) {
                $this->value_taxs[$category?->slug] = (int)$this->income_taxs[$category?->slug] * 0.11;
                $this->amounts[$category?->slug]    = (int)$this->income_taxs[$category?->slug] + (int)$this->value_taxs[$category?->slug];
            }
        }
    }

    public function updatedIncomeTaxs()
    {
        $this->income_tax = $this->value_tax =  $this->amount = 0;
        foreach ($this->categories as $category) {
            $slug = $category?->slug;
            if (isset($this->income_taxs[$slug])) {
                $this->income_tax += (int)$this->income_taxs[$slug];
                $this->value_tax  += (int)$this->value_taxs[$slug];
                $this->amount     += (int)$this->amounts[$slug];
            }
        }
    }

    public function saveData()
    {
        foreach ($this->categories as $key => $category) {
            $check_lower_limit = User::find($this->sales_id)->lowerLimits()->whereHas('category', fn ($query) => $query->where('id', $category?->id))->first();
            if (!$check_lower_limit) {
                return $this->alert('warning', 'Peringatan', [
                    'text' => "Data target batas bawah untuk $category?->name belum diatur !"
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

                foreach ($this->categories as $key => $category) {
                    $invoice->paymentDetails()->updateOrCreate(
                        [
                            'category_id' => $category?->id
                        ],
                        [
                            'category_id' => $category?->id,
                            'income_tax'  => isset($this->income_taxs[$category?->slug]) ? (int)number_format($this->income_taxs[$category?->slug], 0, ',', '') : null,
                            'value_tax'   => isset($this->value_taxs[$category?->slug]) ? (int)number_format($this->value_taxs[$category?->slug], 0, ',', '') : null,
                            'amount'      => isset($this->amounts[$category?->slug]) ? (int)number_format($this->amounts[$category?->slug], 0, ',', '') : null,
                        ]
                    );
                }

                // dd($invoice->paymentDetails()->get());

                if ($this->id_data == null) {
                    $this->createDueDateRule($invoice);

                } elseif ($this?->get_invoice?->due_date != $this->due_date || $this->get_invoice?->date != $this->date) {
                    $invoice->dueDateRules()->delete();
                    $this->createDueDateRule($invoice);
                    foreach ($invoice?->invoiceDetails as $key => $invoice_detail) {
                        $percentage     = null;
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

                $datas = array(
                    'sales_id'   => $invoice?->user?->id,
                );
                foreach ($this->categories as $key => $category) {
                    $this->roofCommission($invoice, $category, $datas);
                }
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
        foreach ($this->categories as $key => $category) {
            $this->income_taxs[$category?->slug] = $this->get_invoice->paymentDetails()->where('category_id', $category?->id)->first()?->income_tax;
            $this->value_taxs[$category?->slug]  = $this->get_invoice->paymentDetails()->where('category_id', $category?->id)->first()?->value_tax;
            $this->amounts[$category?->slug]     = $this->get_invoice->paymentDetails()->where('category_id', $category?->id)->first()?->amount;
        }

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
                $result?->delete();

                $datas = array(
                    'sales_id'   => $invoice?->user?->id,
                );
                foreach ($this->categories as $key => $category) {
                    $this->roofCommission($invoice, $category, $datas, );
                }
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

    public function importInvoiceData()
    {
        $this->validate([
            'file_import' => 'required|file|mimes:xlsx',
        ]);

        try {
            Excel::import(new RoofInvoiceImport, $this->file_import);
        } catch (Exception | Throwable $th) {
            Log::error($th->getMessage());
            Log::error("Ada kesalahan saat Import data faktur atap");
            $this->closeModal();
            return $this->alert('error', 'Gagal', [
                'text' => 'Ada kesalahan saat Import data faktur atap !'
            ]);
        }

        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Faktur Atap berhasil disimpan !, silahkan tunggu beberapa saat'
        ]);
    }
}
