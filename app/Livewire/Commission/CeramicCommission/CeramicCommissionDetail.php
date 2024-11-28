<?php

namespace App\Livewire\Commission\CeramicCommission;

use App\Models\Auth\User;
use App\Models\Commission\Commission;
use App\Models\Commission\CommissionDetail;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class CeramicCommissionDetail extends Component
{
    use LivewireAlert, WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10, $search;

    public $get_commission, $get_user, $get_month_commission;
    public $get_commission_details, $get_list_months, $get_list_years;

    public function render()
    {
        return view('livewire.commission.ceramic-commission.ceramic-commission-detail', [

        ])->extends('layouts.layout.app')->section('content');
    }

    public function mount($sales_id, $month_commission)
    {
        $this->get_commission = Commission::whereHas('user', function ($query) use ($sales_id) {
            $query->where('id', $sales_id);
        })->where('year', (int)Carbon::parse($month_commission)?->format('Y'))->where('month', (int)Carbon::parse($month_commission)?->format('m'))->whereNull('category')->first();

        $this->get_user             = User::find($sales_id);
        $this->get_month_commission = Carbon::parse($month_commission)->translatedFormat('F Y');
        $this->get_list_years       = $this->get_commission?->commissionDetails()->orderBy('year', 'ASC')->distinct()->pluck('year')->toArray();
        $this->get_list_months      = $this->get_commission?->commissionDetails()->orderBy('month', 'ASC')->distinct()->pluck('month')->toArray();
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->reset('');
        $this->dispatch('closeModal');
    }

    public function updated()
    {

    }

    public function getDetailCommission($year, $month, $percentage)
    {
        return $this->get_commission?->commissionDetails()->where('year', $year)->where('month', $month)->where('percentage_of_due_date', $percentage)->first();
    }

    public function getTotalCommission($year, $month, $percentage = [0])
    {
        return $this->get_commission?->commissionDetails()->when($year, function ($query) use ($year) {
            $query->where('year', $year);
        })->when($month, function ($query) use ($month) {
            $query->where('month', $month);
        })->when($percentage, function ($query) use ($percentage) {
            $query->whereNotIn('percentage_of_due_date', $percentage);
        })->sum('value_of_due_date');
    }

    public function getTotalIncome($year, $month, $percentage)
    {
        return $this->get_commission?->commissionDetails()->when($year, function ($query) use ($year) {
            $query->where('year', $year);
        })->when($month, function ($query) use ($month) {
            $query->where('month', $month);
        })->when($percentage, function ($query) use ($percentage) {
            $query->where('percentage_of_due_date', $percentage);
        })->sum('total_income');
    }
}
