<?php

namespace App\Livewire\Commission\RegionCommission;

use App\Models\Auth\User;
use App\Models\Commission\RegionCommission;
use Livewire\Component;

class RegionCommissionIndex extends Component
{
    public function render()
    {
        $datas = RegionCommission::orderBy('month', 'DESC')->distinct()->pluck('user_id', 'month')->toArray();
        return view('livewire.commission.region-commission.region-commission-index', [
            'datas' => $datas
        ])->extends('layouts.layout.app')->section('content');
    }

    public function getUser($id)
    {
        return User::find($id);
    }
}
