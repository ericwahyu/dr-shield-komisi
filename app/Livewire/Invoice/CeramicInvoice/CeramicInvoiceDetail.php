<?php

namespace App\Livewire\Invoice\CeramicInvoice;

use App\Models\Commission\Commission;
use App\Models\Invoice\Invoice;
use App\Models\Invoice\InvoiceDetail;
use App\Traits\CommissionDetailProcess\CeramicCommissionDetailProsses;
use App\Traits\CommissionProcess;
use App\Traits\CommissionProcess\CeramicCommissionProsses;
use App\Traits\GetSystemSetting;
use App\Traits\InvoiceDetailProcess\CeramicInvoiceDetailProsses;
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

class CeramicInvoiceDetail extends Component
{
    use LivewireAlert, WithPagination, GetSystemSetting, CeramicInvoiceDetailProsses, CeramicCommissionDetailProsses;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10, $search;

    public $due_date_ceramic_rules;
    public $get_invoice, $sales_code, $date, $invoice_number, $customer, $id_customer, $due_date, $income_tax, $value_tax, $amount;
    public $payment_amount, $remaining_amount;
    public $get_invoice_detail, $id_data, $type, $invoice_detail_amount, $invoice_detail_date, $percentage;

    public function render()
    {
        $this->payment_amount   = "Rp. ". number_format((int)$this->get_invoice->invoiceDetails()->where('version', 1)->sum('amount'), 0, ',', '.');
        $this->remaining_amount = "Rp. ". number_format((int)$this->get_invoice?->amount - (int)$this->get_invoice->invoiceDetails()->where('version', 1)->sum('amount'), 0, ',', '.');
        return view('livewire.invoice.ceramic-invoice.ceramic-invoice-detail',[
            'invoice_details' => $this->get_invoice?->invoiceDetails()->where('version', 1)->get(),
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

        $this->due_date_ceramic_rules = $this->get_invoice->dueDateRules()->where('version', 1)->get();
        $this->type                   = 'ceramic';
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
                'version'             => 1,
            );

            $this->percentage = $this->_percentageCeramicInvoiceDetail($this->get_invoice, $datas);
        }
    }

    public function closeModal()
    {
        $this->reset('get_invoice_detail','id_data', 'invoice_detail_amount', 'invoice_detail_date', 'percentage');
        $this->dispatch('closeModal');
    }

    public function saveData()
    {
        $this->validate([
            'type'                  => 'required',
            'invoice_detail_date'   => 'required|date',
            'invoice_detail_amount' => 'required|numeric',
            'percentage'            => 'required|numeric',
        ]);


        try {
            DB::transaction(function () {

                $datas = array(
                    'id_data'               => $this->id_data,
                    'version'               => 1,
                    'invoice_detail_amount' => $this->invoice_detail_amount,
                    'invoice_detail_date'   => $this->invoice_detail_date,
                    'percentage'            => $this->percentage,
                );

                $this->_ceramicInvoiceDetail($this->get_invoice, $datas);

                $datas = array(
                    'version'             => 1,
                    'invoice_detail_date' => $this->invoice_detail_date
                );
                $this->_ceramicCommissionDetail($this->get_invoice, $datas);
            });
        } catch (Exception | Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
            Log::error("Terjadi Kesalahan Saat Menyimpan Data Detail Faktur Keramik!");

            return $this->alert('error', 'Maaf', [
                'text' => 'Terjadi Kesalahan Saat Menyimpan Data Detail Faktur Keramik !'
            ]);
        }
        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Detail Faktur Keramik Telah Disimpan !'
        ]);
    }

    public function edit($id)
    {
        $this->get_invoice_detail    = Invoice::find($this->get_invoice?->id)->invoiceDetails()->where('id', $id)->first();
        $this->id_data               = $this->get_invoice_detail?->id;
        $this->type                  = $this->get_invoice_detail?->type;
        $this->invoice_detail_date   = $this->get_invoice_detail?->date?->format('Y-m-d');
        $this->invoice_detail_amount = $this->get_invoice_detail?->amount;
        $this->percentage            = $this->get_invoice_detail?->percentage;

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
                $result = Invoice::find($this->get_invoice?->id)->invoiceDetails()->where('id', $data['inputAttributes']['id'])->first();
                $invoice = $result;
                $result?->delete();

                $datas = array(
                    'version'             => 1,
                    'invoice_detail_date' => Invoice::find($this->get_invoice?->id)->invoiceDetails()->where('id', $data['inputAttributes']['id'])->withTrashed()->first()?->date?->format('Y-m-d')
                );
                $this->_ceramicCommissionDetail($this->get_invoice, $datas);
            });

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return $this->alert('error', 'Maaf', [
                'text' => 'Terjadi Kesalahan Saat Menghapus Data Detail Faktur Keramik!'
            ]);
        }

        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Detail Faktur Keramik Telah Dihapus !'
        ]);
    }
}
