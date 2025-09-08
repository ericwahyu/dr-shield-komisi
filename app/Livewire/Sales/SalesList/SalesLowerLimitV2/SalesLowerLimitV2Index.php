<?php

namespace App\Livewire\Sales\SalesList\SalesLowerLimitV2;

use App\Models\Auth\User;
use App\Models\System\Category;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class SalesLowerLimitV2Index extends Component
{
    use LivewireAlert, WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10, $search;

    public $get_user, $categories;
    public $get_lower_limit, $id_data, $category, $number, $target_payment, $value;

    public function render()
    {
        return view('livewire.sales.sales-list.sales-lower-limit-v2.sales-lower-limit-v2-index',[

        ])->extends('layouts.layout.app')->section('content');
    }

    public function mount($id)
    {
        $this->get_user   = User::find($id);
        $this->categories = Category::where('type', $this->get_user?->userDetail?->sales_type)->where('version', 2)->where('slug', 'dr-sonne')->get();
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
            'category'       => 'nullable',
            'target_payment' => 'required|numeric',
            'value'          => 'required|numeric',
        ]);

        $get_unique_lower_limit = $this->get_user->lowerLimits()->when($this->category != null, function ($query) {
            $query->whereHas('category', fn ($query) => $query->where('type', $this->get_user?->userDetail?->sales_type)->where('version', 2)->where('slug', $this->category));
        })->when($this->category == null, function ($query) {
            $query->whereNull('category_id');
        })->where('value', $this->value)->where('version', 2)->first();

        if ($get_unique_lower_limit && $this->id_data == null) {
            // $this->closeModal();
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
                        'category_id'    => Category::where('type', $this->get_user?->userDetail?->sales_type)->where('version', 2)->where('slug', $this->category)->first()?->id,
                        'version'        => 2,
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

    public function getLowerLimits($category)
    {
        // dd($category);
        return $this->get_user->lowerLimits()
        ->when($category != null, function ($query) use ($category) {
            $query->whereHas('category', function ($query) use ($category) {
                $query->where('type', $this->get_user?->userDetail?->sales_type)->where('slug', $category);
            });
        })
        ->when($category == null, function ($query) use ($category) {
            $query->whereNull('category_id');
        })
        ->where('version', 2)->orderBy('value', 'DESC')->get();
    }

    public function edit($id)
    {
        $this->get_lower_limit = $this->get_user->lowerLimits()->where('version', 2)->where('id', $id)->first();
        $this->id_data         = $this->get_lower_limit?->id;
        $this->category        = $this->get_lower_limit?->category?->slug;
        $this->target_payment  = $this->get_lower_limit?->target_payment;
        $this->value           = $this->get_lower_limit?->value;

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
                $result = $this->get_user->lowerLimits()->where('version', 2)->where('id', $data['inputAttributes']['id'])->first();
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
