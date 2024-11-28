<?php

namespace App\Livewire\Sales\SalesList\SalesLowerLimit;

use App\Models\Auth\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class SalesLowerLimitIndex extends Component
{
    use LivewireAlert, WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10, $search;

    public $get_user, $name, $depo, $civil_registration_number, $sales_type, $sales_code;
    public $get_lower_limit, $id_data, $category, $number, $target_payment, $value;

    public function render()
    {
        return view('livewire.sales.sales-list.sales-lower-limit.sales-lower-limit-index', [
            'ceramic_lower_limits'   => $this->get_user->lowerLimits()->whereHas('user.userDetail', function ($query) {
                $query->where('sales_type', $this->get_user?->userDetail?->sales_type);
            })->orderBy('target_payment', 'ASC')->get(),
            'dr_shield_lower_limits' => $this->get_user->lowerLimits()->whereHas('user.userDetail', function ($query) {
                $query->where('sales_type', $this->get_user?->userDetail?->sales_type);
            })->where('category', 'dr-shield')->orderBy('target_payment', 'ASC')->get(),
            'dr_sonne_lower_limits'  => $this->get_user->lowerLimits()->whereHas('user.userDetail', function ($query) {
                $query->where('sales_type', $this->get_user?->userDetail?->sales_type);
            })->where('category', 'dr-sonne')->orderBy('target_payment', 'ASC')->get(),
        ])->extends('layouts.layout.app')->section('content');
    }

    public function mount($id)
    {
        $this->get_user                  = User::find($id);
        $this->name                      = $this->get_user?->name;
        $this->sales_code                = $this->get_user?->userDetail?->sales_code;
        $this->civil_registration_number = $this->get_user?->userDetail?->civil_registration_number;
        $this->sales_type                = $this->get_user?->userDetail?->sales_type == 'roof' ? 'Atap' : ($this->get_user?->userDetail?->sales_type == 'ceramic' ? 'Keramik' : '-');
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->reset('id_data', 'category', 'number', 'target_payment', 'value');
        $this->dispatch('closeModal');
    }

    public function updated()
    {

    }

    public function saveData()
    {
        $this->validate([
            'category'       => $this->get_user?->userDetail?->sales_type == 'roof' ? 'required' : 'nullable',
            'target_payment' => 'required|numeric',
            'value'          => 'required|numeric',
        ]);

        $get_unique_lower_limit = $this->get_user->lowerLimits()->where('category', $this->category)->where('value', $this->value)->first();
        if ($get_unique_lower_limit) {
            $this->closeModal();
            return $this->alert('warning', 'Pemberitahuan', [
                'text' => 'Persentase Batas Bawah Target sudah tersedia !'
            ]);
        }
        try {
            DB::transaction(function () {
                $this->get_user->lowerLimits()->updateOrCreate(
                    [
                        'id' => $this->id_data
                    ],
                    [
                        'category' => $this->category,
                        // 'number'         => $this->number ? $this->number : (int)$this->get_user->lowerLimits()->where('type', $this->type)->max('number') + 1,
                        'target_payment' => $this->target_payment,
                        'value'          => $this->value,
                    ]
                );
            });
        } catch (Exception | Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
            Log::error("Terjadi Kesalahan Saat Menyimpan Data Batas Bawah Target !");

            return $this->alert('error', 'Maaf', [
                'text' => 'Terjadi Kesalahan Saat Menyimpan Data Batas Bawah Target !'
            ]);
        }
        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Batas Bawah Target Telah Disimpan !'
        ]);
    }

    public function edit($id)
    {
        $this->get_lower_limit = $this->get_user->lowerLimits()->where('id', $id)->first();
        $this->id_data         = $this->get_lower_limit?->id;
        $this->category        = $this->get_lower_limit?->category;
        $this->target_payment  = $this->get_lower_limit?->target_payment;
        $this->value           = $this->get_lower_limit?->value;

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
                $result = $this->get_user->lowerLimits()->where('id', $data['inputAttributes']['id'])->first();
                $result?->delete();
            });

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return $this->alert('error', 'Maaf', [
                'text' => 'Terjadi Kesalahan Saat Menghapus Data Batas Bawah Target!'
            ]);
        }

        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Batas Bawah Target Telah Dihapus !'
        ]);
    }
}
