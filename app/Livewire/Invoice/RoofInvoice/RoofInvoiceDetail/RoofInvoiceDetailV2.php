<?php

namespace App\Livewire\Invoice\RoofInvoice\RoofInvoiceDetail;

use App\Models\Invoice\Invoice;
use App\Models\System\Category;
use App\Traits\CommissionDetailProcess\RoofCommissionDetailProsses;
use App\Traits\CommissionProcess;
use App\Traits\GetSystemSetting;
use App\Traits\InvoiceDetailProcess\RoofInvoiceDetailProsses;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Throwable;

class RoofInvoiceDetailV2 extends Component
{
    use LivewireAlert, WithPagination, GetSystemSetting, RoofInvoiceDetailProsses, RoofCommissionDetailProsses;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10, $search;

    public $due_date_roof_rules;
    public $get_invoice, $sales_code, $date, $invoice_number, $customer, $id_customer, $due_date, $income_tax, $value_tax, $amount;
    public $amounts = [], $payment_amounts = [], $remaining_amounts = [];
    public $get_invoice_detail, $id_data, $category, $invoice_detail_amount, $invoice_detail_date, $percentage;
    public $categories;

    public function render()
    {
        foreach ($this->categories as $key => $category) {
            $category = $category != null ? Category::where('slug', $category)->where('version', 2)->first() : $category;

            $this->payment_amounts[$category?->slug]   = "Rp. ". number_format((int)$this->get_invoice->invoiceDetails()
            ->when($category != null, function ($query) use ($category) {
                $query->where('category_id', $category?->id);
            })->when($category == null, function ($query) use ($category) {
                $query->whereNull('category_id');
            })->sum('amount'), 0, ',', '.');

            $this->remaining_amounts[$category?->slug] = "Rp. ". number_format((int)$this->amounts[$category?->slug] - (int)$this->get_invoice->invoiceDetails()->when($category != null, function ($query) use ($category) {
                $query->where('category_id', $category?->id);
            })->when($category == null, function ($query) use ($category) {
                $query->whereNull('category_id');
            })->sum('amount'), 0, ',', '.');
        }
        return view('livewire.invoice.roof-invoice.roof-invoice-detail.roof-invoice-detail-v2', [
            'invoice_details' => $this->get_invoice?->invoiceDetails()->where('version', 2)->get(),
        ])->extends('layouts.layout.app')->section('content');
    }

    public function mount($id)
    {
        $this->get_invoice    = Invoice::find($id);
        $this->date           = $this->get_invoice?->date?->format('d M Y');
        $this->invoice_number = $this->get_invoice?->invoice_number;
        $this->sales_code     = $this->get_invoice?->user?->userDetail?->sales_code;
        $this->due_date       = $this->get_invoice?->due_date. " Hari";
        $this->customer       = $this->get_invoice?->customer;
        $this->id_customer    = $this->get_invoice?->id_customer;
        $this->income_tax     = "Rp. ". number_format($this->get_invoice?->income_tax, 0, ',', '.');
        $this->value_tax      = "Rp. ". number_format($this->get_invoice?->value_tax, 0, ',', '.');
        $this->amount         = "Rp. ". number_format($this->get_invoice?->amount, 0, ',', '.');

        $this->due_date_roof_rules = $this->get_invoice->dueDateRules()->where('version', 2)->get();

        $this->categories = [null, 'dr-sonne'];

        foreach ($this->categories as $key => $category) {
            $category = $category != null ? Category::where('slug', $category)->where('version', 2)->first() : $category;

            $this->amounts[$category?->slug] = $this->get_invoice?->paymentDetails()->where('version', 2)

            ->when($category != null, function ($query) use ($category) {
                $query->where('category_id', $category?->id);
            })->when($category == null, function ($query) use ($category) {
                $query->whereNull('category_id');
            })->first()?->amount;
        }

        // dd($this->amounts);
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function updated()
    {
        if ($this->invoice_detail_date) {

            $datas = array(
                'invoice_detail_date' => $this->invoice_detail_date,
                'version'             => 2,
            );

            $this->percentage = $this->_percentageRoofInvoiceDetail($this->get_invoice, $datas) ;
        }
    }

    public function closeModal()
    {
        $this->reset('get_invoice_detail', 'id_data', 'category', 'invoice_detail_amount', 'invoice_detail_date', 'percentage');
        $this->dispatch('closeModal');
    }

    public function saveData()
    {
        $this->validate([
            'category'              => 'nullable',
            'invoice_detail_date'   => 'required|date',
            'invoice_detail_amount' => 'required|numeric',
            'percentage'            => 'required|numeric',
        ]);

        // if ($this->id_data == null && (int)$this->get_invoice?->paymentDetails()->where('category_id', $this->category)->sum('amount') - ((int)$this->get_invoice->invoiceDetails()->where('category_id', $this->category)->sum('amount') + (int)$this->invoice_detail_amount) < 0) {
        //     return $this->alert('warning', 'Pemberitahuan', [
        //         'text' => 'Nominal pembayaran melebihi total !'
        //     ]);
        // }

        try {
            DB::transaction(function () {
                $datas = array(
                    'id_data'               => $this->id_data,
                    'version'               => 2,
                    'category_id'           => $this->category != null ? Category::where('slug', $this->category)->where('version', 2)->first()?->id : null,
                    'invoice_detail_amount' => $this->invoice_detail_amount,
                    'invoice_detail_date'   => $this->invoice_detail_date,
                    'percentage'            => $this->percentage,
                );

                $this->_roofInvoiceDetail($this->get_invoice, $datas);

                $datas = array(
                    'version'             => 2,
                    'invoice_detail_date' => Carbon::parse($this->invoice_detail_date)->toDateString()
                );
                $this->_roofCommissionDetail($this->get_invoice, $datas);
            });
        } catch (Exception | Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
            Log::error("Terjadi Kesalahan Saat Menyimpan Data Detail Faktur Atap!");

            return $this->alert('error', 'Maaf', [
                'text' => 'Terjadi Kesalahan Saat Menyimpan Data Detail Faktur Atap !'
            ]);
        }
        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Detail Faktur Atap Telah Disimpan !'
        ]);
    }

    public function edit($id)
    {
        $this->get_invoice_detail    = Invoice::find($this->get_invoice?->id)->invoiceDetails()->where('id', $id)->first();
        $this->id_data               = $this->get_invoice_detail?->id;
        $this->category              = $this->get_invoice_detail?->category?->slug;
        $this->invoice_detail_date   = $this->get_invoice_detail?->date?->format('Y-m-d');
        $this->invoice_detail_amount = $this->get_invoice_detail?->amount;
        $this->percentage            = $this->get_invoice_detail?->percentage;

        $this->dispatch('openModal-v2');
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
                $result = Invoice::find($this->get_invoice?->id)->invoiceDetails()->where('id', $data['inputAttributes']['id'])->first();
                $invoice = $result;
                $result?->delete();

                $datas = array(
                    'version' => 2,
                    'invoice_detail_date' => Invoice::find($this->get_invoice?->id)->invoiceDetails()->where('id', $data['inputAttributes']['id'])->withTrashed()->first()?->date?->format('Y-m-d')
                );
                $this->_roofCommissionDetail($this->get_invoice, $datas);
            });

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return $this->alert('error', 'Maaf', [
                'text' => 'Terjadi Kesalahan Saat Menghapus Data Detail Faktur Atap!'
            ]);
        }

        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Detail Faktur Atap Telah Dihapus !'
        ]);
    }
}
