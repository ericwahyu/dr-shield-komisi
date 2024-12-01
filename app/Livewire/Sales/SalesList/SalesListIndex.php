<?php

namespace App\Livewire\Sales\SalesList;

use App\Models\Auth\User;
use App\Models\Auth\UserDetail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class SalesListIndex extends Component
{
    use LivewireAlert, WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10, $search;

    public $id_data, $name, $depo, $civil_registration_number, $sales_type, $sales_code;

    public function render()
    {
        $users =  User::search($this->search);
        return view('livewire.sales.sales-list.sales-list-index', [
            'sales' => $users->role('sales')->paginate($this->perPage)
        ])->extends('layouts.layout.app')->section('content');
    }

    public function mount()
    {
        // dd(env('APP_NAME'));
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->reset('id_data', 'name', 'depo', 'civil_registration_number', 'sales_type', 'sales_code');
        $this->dispatch('closeModal');
    }

    public function updated()
    {
        if ($this->name && $this->depo) {
            $this->sales_code = strtoupper($this->depo). ' - ' .explode(' ', $this->name)[0] ;
        } else {
            $this->sales_code = '';
        }
    }

    public function saveData()
    {
        $this->validate([
            'name'                      => 'required',
            'depo'                      => 'required',
            'civil_registration_number' => 'nullable|numeric',
            'sales_type'                => 'required',
            'sales_code'                => 'required',
        ]);

        try {
            DB::transaction(function () {
                $user = User::updateOrCreate(
                    [
                        'id' => $this->id_data
                    ],
                    [
                        'name' => $this->name,
                    ]
                );

                $user->userDetail()->updateOrCreate(
                    [
                        'user_id' => $user?->id
                    ],
                    [
                        'civil_registration_number' => $this->civil_registration_number,
                        'depo'                      => strtoupper($this->depo),
                        'sales_type'                => $this->sales_type,
                        'sales_code'                => $this->sales_code,
                    ]
                );

                $user->assignRole('sales');
            });
        } catch (Exception | Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
            Log::error("Terjadi Kesalahan Saat Menyimpan Data Sales !");

            return $this->alert('error', 'Maaf', [
                'text' => 'Terjadi Kesalahan Saat Menyimpan Data Sales !'
            ]);
        }
        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Sales Telah Disimpan !'
        ]);
    }

    public function edit($id)
    {
        $get_user                        = User::find($id);
        $this->id_data                   = $get_user?->id;
        $this->name                      = $get_user?->name;
        $this->depo                      = $get_user?->userDetail?->depo;
        $this->civil_registration_number = $get_user?->userDetail?->civil_registration_number;
        $this->sales_type                = $get_user?->userDetail?->sales_type;
        $this->sales_code                = $get_user?->userDetail?->sales_code;

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
                $result = User::find($data['inputAttributes']['id']);
                $result?->delete();
            });

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return $this->alert('error', 'Maaf', [
                'text' => 'Terjadi Kesalahan Saat Menghapus Data Pelanggan!'
            ]);
        }

        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Pelanggan Telah Dihapus !'
        ]);
    }
}
