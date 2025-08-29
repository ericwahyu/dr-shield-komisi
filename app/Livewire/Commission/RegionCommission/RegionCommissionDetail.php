<?php

namespace App\Livewire\Commission\RegionCommission;

use App\Models\Commission\RegionCommission;
use Carbon\Carbon;
use Livewire\Component;

class RegionCommissionDetail extends Component
{
    public $month;
    public $datas = [];
    public $target_percentage = [];
    public $payment_percentage = [];

    public function render()
    {
        return view('livewire.commission.region-commission.region-commission-detail')->extends('layouts.layout.app')->section('content');
    }

    public function mount($month)
    {
        $this->month = Carbon::parse($month);
        $this->target_percentage = [100, 90, 80, 70];
        $this->payment_percentage = [
            100 => 'Ontime',
            50  => 'Lebih 16 - 22 Hari',
            0   => 'Hangus'
        ];
        $this->datas = RegionCommission::where('month', $month)->get();
        
    }
}
