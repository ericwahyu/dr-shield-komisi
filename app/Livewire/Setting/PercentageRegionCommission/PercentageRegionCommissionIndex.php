<?php

namespace App\Livewire\Setting\PercentageRegionCommission;

use Livewire\Component;
use App\Models\Auth\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\System\PercentageRegionCommission;
use Exception;
use Throwable;

class PercentageRegionCommissionIndex extends Component
{
    use WithPagination, LivewireAlert;

    public $id_data, $type, $percentage_target, $percentage_commission;

    public function render()
    {
        $percentage_roofs = PercentageRegionCommission::where('type', 'roof')->orderBy('percentage_target', 'DESC')->get();
        $percentage_ceramics = PercentageRegionCommission::where('type', 'ceramic')->orderBy('percentage_target', 'DESC')->get();
        return view('livewire.setting.percentage-region-commission.percentage-region-commission-index', [
            'percentage_roofs' => $percentage_roofs,
            'percentage_ceramics' => $percentage_ceramics,
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
        $this->reset('type', 'percentage_target', 'percentage_commission');
        $this->dispatch('closeModal');
    }

    public function saveData()
    {
        $this->validate([
            'type'                  => 'required',
            'percentage_target'     => 'required|numeric',
            'percentage_commission' => 'required|numeric',
        ]);

        $unique = PercentageRegionCommission::where('type', $this->type)->where('percentage_target', $this->percentage_target)->first();
        if ($unique && $this->id_data == null) {
            return $this->alert('warning', 'Maaf', [
                'text' => 'Kode dan persentase tersebut sudah tersedia',
            ]);
        }

        try {
            DB::transaction(function () {
                PercentageRegionCommission::updateOrCreate(
                    [
                        'type'              => $this->type,
                        'percentage_target' => $this->percentage_target,
                    ],
                    [
                        'percentage_commission' => $this->percentage_commission,
                    ]
                );
            });
        } catch (Exception | Throwable $th) {
            DB::rollback();
            $errors = [
                'message' => $th->getMessage(),
                'file'    => $th->getFile(),
                'line'    => $th->getLine(),
            ];
            Log::error("Terjadi Kesalahan Saat Menyimpan Data !", $errors);

            return $this->alert('error', 'Maaf', [
                'text' => 'Terjadi Kesalahan Saat Menyimpan Data !'
            ]);
        }
        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Berhasil Disimpan !'
        ]);
    }

    public function edit($id)
    {
        $get_data                    = PercentageRegionCommission::find($id);
        $this->id_data               = $get_data?->id;
        $this->type                  = $get_data?->type;
        $this->percentage_target     = $get_data?->percentage_target;
        $this->percentage_commission = $get_data?->percentage_commission;

        $this->dispatch('openModal');
    }

    public function deleteConfirm($id)
    {
        $this->confirm('Konfirmasi', [
            'inputAttributes'    => ['id' => $id],
            'onConfirmed'        => 'delete',
            'text'               => 'Apakah Anda yakin akan menghapus data ini',
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
                $result = PercentageRegionCommission::find($data['inputAttributes']['id']);
                $result->delete();
            });

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return $this->alert('error', 'Maaf', [
                'text' => 'Terjadi Kesalahan Saat Menghapus Data!'
            ]);
        }

        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Berhasil Dihapus !'
        ]);
    }
}
