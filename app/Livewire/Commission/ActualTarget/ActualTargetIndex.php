<?php

namespace App\Livewire\Commission\ActualTarget;

use App\Models\Commission\ActualTarget;
use App\Models\System\Category;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Throwable;

class ActualTargetIndex extends Component
{
    use LivewireAlert, WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10, $search;

    public $id_data, $category, $target, $actual, $value_commission;

    public function render()
    {
        return view('livewire.commission.actual-target.actual-target-index', [
            'categories' => Category::where('type', 'roof')->where('version', 1)->pluck('slug')->toArray(),
            'actuals'    => ActualTarget::whereHas('category', fn ($query) => $query->where('type', 'roof'))->distinct()->orderBy('actual', 'DESC')->pluck('actual')->toArray(),
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
        $this->reset('id_data', 'category', 'target', 'actual', 'value_commission');
        $this->dispatch('closeModal');
    }

    public function updated()
    {

    }

    public function saveData()
    {
        $this->validate([
            'category'         => 'required',
            'target'           => 'nullable|numeric',
            'actual'           => 'nullable|numeric',
            'value_commission' => 'nullable|numeric',
        ]);

        try {
            DB::transaction(function () {
                ActualTarget::updateOrCreate(
                    [
                        'id' => $this->id_data,
                    ],
                    [
                        // 'type'             => 'roof',
                        'category_id'      => Category::where('type', 'roof')->where('slug', $this->category)->first()?->id,
                        'target'           => $this->target,
                        'actual'           => $this->actual,
                        'value_commission' => $this->value_commission,
                    ]
                );
            });
        } catch (Exception | Throwable $th) {
            DB::rollback();
            Log::error($th->getMessage());
            Log::error("Terjadi Kesalahan Saat Menyimpan Data Target Aktual Atap !");

            return $this->alert('error', 'Maaf', [
                'text' => 'Terjadi Kesalahan Saat Menyimpan Data Target Aktual Atap !'
            ]);
        }
        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Target Aktual Atap Telah Disimpan !'
        ]);
    }

    public function edit($category, $actual, $target)
    {
        $get_actual_target = ActualTarget::whereHas('category', function ($query) use ($category) {
            $query->where('type','roof')->where('slug', $category);
        })->where('target', $target)->where('actual', $actual)->first();

        $this->id_data          = $get_actual_target?->id;
        $this->category         = $get_actual_target?->category?->slug;
        $this->actual           = $get_actual_target?->actual;
        $this->target           = $get_actual_target?->target;
        $this->value_commission = $get_actual_target?->value_commission;

        $this->dispatch('openModal');
    }

    public function deleteConfirm($category, $actual, $target)
    {
        $this->confirm('Konfirmasi', [
            'inputAttributes'    => ['category' => $category, 'actual' => $actual, 'target' => $target],
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
                $result = ActualTarget::whereHas('category', function ($query) use ($data) {
                    $query->where('type','roof')->where('slug', $data['inputAttributes']['category']);
                })->where('target', $data['inputAttributes']['target'])->where('actual', $data['inputAttributes']['actual'])->first();
                $result?->delete();
            });

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return $this->alert('error', 'Maaf', [
                'text' => 'Terjadi Kesalahan Saat Menghapus Data Target Aktual Atap!'
            ]);
        }

        $this->closeModal();

        return $this->alert('success', 'Berhasil', [
            'text' => 'Data Target Aktual Atap Telah Dihapus !'
        ]);
    }

    public function getTargets($category)
    {
        return ActualTarget::whereHas('category', function ($query) use ($category) {
            $query->where('type','roof')->where('slug', $category);
        })->distinct()->orderBy('target', 'DESC')->pluck('target')->toArray();
    }

    public function getActualTarget($category, $actual, $target)
    {
        return ActualTarget::whereHas('category', function ($query) use ($category) {
            $query->where('type','roof')->where('slug', $category);
        })->where('target', $target)->where('actual', $actual)->first();
    }
}
