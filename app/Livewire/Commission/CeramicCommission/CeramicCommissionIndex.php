<?php

namespace App\Livewire\Commission\CeramicCommission;

use App\Models\Auth\User;
use App\Models\Commission\Commission;
use App\Models\Invoice\Invoice;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class CeramicCommissionIndex extends Component
{
    use LivewireAlert, WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10, $search;

    public $filter_month;
    public $selectYear, $selectMonth;

    public function render()
    {
        $users =  User::search($this->search);

        return view('livewire.commission.ceramic-commission.ceramic-commission-index', [
            'sales' => $users->role('sales')->whereHas('userDetail', function ($query) {
                $query->where('sales_type', 'ceramic');
            })->paginate($this->perPage)
        ])->extends('layouts.layout.app')->section('content');
    }

    public function mount()
    {
        $this->filter_month = Carbon::now()->format('Y-m');
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

    public function commissionSales($user_id)
    {
        $get_commission = Commission::whereHas('user', function ($query) use ($user_id) {
            $query->where('id', $user_id);
        })->where('year', (int)Carbon::parse($this->filter_month)->format('Y'))->where('month', (int)Carbon::parse($this->filter_month)->format('m'))->first();

        return $get_commission;
    }

    public function lowerLimiCommissions($user_id)
    {
        $get_commission = Commission::whereHas('user', function ($query) use ($user_id) {
            $query->where('id', $user_id);
        })->where('year', (int)Carbon::parse($this->filter_month)->format('Y'))->where('month', (int)Carbon::parse($this->filter_month)->format('m'))->first();

        if (!$get_commission ) {
            return [];
        }
        return $get_commission?->lowerLimitCommissions()->orderBy('value', 'DESC')->get();
    }

    public function totalCommission($user_id)
    {
        $get_commission = Commission::whereHas('user', function ($query) use ($user_id) {
            $query->where('id', $user_id);
        })->where('year', (int)Carbon::parse($this->filter_month)->format('Y'))->where('month', (int)Carbon::parse($this->filter_month)->format('m'))->first();

        if (!$get_commission || $get_commission?->status == 'not-reach') {
            return null;
        }

        return $get_commission?->value_commission;
    }
}
