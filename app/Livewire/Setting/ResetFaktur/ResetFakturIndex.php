<?php

namespace App\Livewire\Setting\ResetFaktur;

use App\Models\Auth\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Invoice\Invoice;
use App\Models\System\DataReset;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice\DueDateRule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Commission\Commission;
use App\Models\Invoice\InvoiceDetail;
use App\Models\Invoice\PaymentDetail;
use App\Models\Commission\CommissionDetail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Commission\LowerLimitCommission;

class ResetFakturIndex extends Component
{
    use LivewireAlert, WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10, $search;

    public $data_reset, $sales_id;

    public function render()
    {
        $data_resets = DataReset::search($this->search);
        return view('livewire.setting.reset-faktur.reset-faktur-index', [
            'reset_datas' => $data_resets->latest()->paginate($this->perPage),
            'sales' => User::role('sales')->whereHas('userDetail', function ($query) {
                $query->where('sales_type', 'roof');
            })->select('id', 'name')->orderBy('name', 'ASC')->get(),
        ])->extends('layouts.layout.app')->section('content');
    }

    public function mount()
    {
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->reset('data_reset');
        $this->dispatch('closeModal');
    }

    public function saveData()
    {
        $this->validate(
            [
                'data_reset' => 'required|date'
            ],
            [
                'date_reset' => 'Tanggal data import yang akan di reset wajib diisi'
            ]
        );
        $note = 'Melakukan reset data import yang telah di masukkan pada tanggal : '. $this->data_reset;
        $note .= $this->sales_id ? ' (sales : '. User::find($this->sales_id)?->name .')' : ' (reset Semua Sales)';

        try {
            DB::beginTransaction();
                DataReset::create([
                    'user_id'    => Auth::user()?->id,
                    'data_reset' => $this->data_reset,
                    'note'       => $note,
                    'date_reset' => Carbon::now()
                ]);

                $invoice_ids = Invoice::whereDate('created_at', $this->data_reset)->when($this->sales_id != null, function ($query) {
                    $query->where('user_id', $this->sales_id);
                })->pluck('id')->toArray();
                InvoiceDetail::whereIn('invoice_id', $invoice_ids)->forceDelete();
                PaymentDetail::whereIn('invoice_id', $invoice_ids)->forceDelete();
                DueDateRule::whereIn('invoice_id', $invoice_ids)->forceDelete();

                $commission_ids = Commission::whereDate('created_at', $this->data_reset)->when($this->sales_id != null, function ($query) {
                    $query->where('user_id', $this->sales_id);
                })->pluck('id')->toArray();
                LowerLimitCommission::whereIn('commission_id', $commission_ids)->forceDelete();
                CommissionDetail::whereIn('commission_id', $commission_ids)->forceDelete();

                Invoice::whereDate('created_at', $this->data_reset)->when($this->sales_id != null, function ($query) {
                    $query->where('user_id', $this->sales_id);
                })->forceDelete();
                Commission::whereDate('created_at', $this->data_reset)->when($this->sales_id != null, function ($query) {
                    $query->where('user_id', $this->sales_id);
                })->forceDelete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
             $errors = [
                'message' => $th->getMessage(),
                'file'    => $th->getFile(),
                'line'    => $th->getLine(),
            ];
            Log::error("Terjadi Kesalahan Saat Mereset Data Import!", $errors);

            return $this->alert('error', 'Maaf', [
                'text' => 'Terjadi Kesalahan Saat Mereset Data Import !'
            ]);
        }

        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data History Reset Telah Disimpan !'
        ]);
    }
}
