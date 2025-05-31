<?php

namespace App\Livewire\Commission\RoofCommission;

use App\Exports\Commission\RoofCommission\RoofCommissionVersion2;
use App\Models\Auth\User;
use App\Models\Commission\Commission;
use App\Models\System\Category;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class RoofCommissionIndex extends Component
{
    use LivewireAlert, WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10, $search;

    public $filter_month;
    public $selectYear, $selectMonth;
    public $categories;

    public $export_version, $export_month;

    public function render()
    {
        $users =  User::search($this->search);

        return view('livewire.commission.roof-commission.roof-commission-index', [
            'sales' => $users->role('sales')->whereHas('userDetail', function ($query) {
                $query->where('sales_type', 'roof');
            })->get()
        ])->extends('layouts.layout.app')->section('content');
    }

    public function mount()
    {
        $this->filter_month = Carbon::now()->format('Y-m');
        // $this->filter_month = Carbon::parse('2024-04')->format('Y-m');
        $this->categories   = Category::where('type', 'roof')->where('version', 1)->get();
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function closeModal()
    {
        // $this->reset('');
        $this->dispatch('closeModal');
    }

    public function updated()
    {

    }

    public function commissionSales($user_id, $category)
    {
        $get_commission = Commission::whereHas('user', function ($query) use ($user_id) {
            $query->where('id', $user_id);
        })->where('year', (int)Carbon::parse($this->filter_month)->format('Y'))->where('month', (int)Carbon::parse($this->filter_month)->format('m'))->where('category_id', $category?->id)->where('version', 1)->first();

        return $get_commission;
    }

    public function lowerLimiCommissions($user_id, $category)
    {
        $get_commission = Commission::whereHas('user', function ($query) use ($user_id) {
            $query->where('id', $user_id);
        })->where('year', (int)Carbon::parse($this->filter_month)->format('Y'))->where('month', (int)Carbon::parse($this->filter_month)->format('m'))->where('category_id', $category?->id)->where('version', 1)->first();
        // dd($user_id, $category, $get_commission);

        if (!$get_commission ) {
            return [];
        }
        return $get_commission?->lowerLimitCommissions()->orderBy('value', 'DESC')->get();
    }

    public function totalCommission($user_id, $category)
    {
        $get_commission = Commission::whereHas('user', function ($query) use ($user_id) {
            $query->where('id', $user_id);
        })->where('year', (int)Carbon::parse($this->filter_month)->format('Y'))->where('month', (int)Carbon::parse($this->filter_month)->format('m'))->where('category_id', $category?->id)->where('version', 1)->first();

        if (!$get_commission || $get_commission?->status == 'not-reach') {
            return null;
        }

        return $get_commission?->commissionDetails()->whereNotIn('percentage_of_due_date', [0])->sum('value_of_due_date');
    }

    public function exportData()
    {
        $this->validate([
            'export_version' => 'required',
            'export_month'   => 'required',
        ]);

        $export_month = $this->export_month;

        $this->closeModal();

        return Excel::download(new RoofCommissionVersion2($export_month), 'Komisi Atap V2-' . Carbon::parse($this->export_month)->format('Y-m') . '.xlsx');
    }
}
