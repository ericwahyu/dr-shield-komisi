<?php

namespace App\Livewire\Commission\RegionCommission;

use App\Exports\Commission\RegionCommission\RegionCommissionExport;
use App\Models\Commission\RegionCommission;
use App\Models\System\PercentageRegionCommission;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class RegionCommissionDetail extends Component
{
    public $month;
    public $roof_datas = [], $ceramic_datas = [];
    public $target_percentage_roof = [], $target_percentage_ceramic = [];
    public $payment_percentage = [];

    public function render()
    {
        return view('livewire.commission.region-commission.region-commission-detail')->extends('layouts.layout.app')->section('content');
    }

    public function mount($month)
    {
        $this->month = Carbon::parse($month);
        // $this->target_percentage = [100, 90, 80, 70];
        $this->target_percentage_roof = PercentageRegionCommission::where('type', 'roof')->orderBy('percentage_target', 'DESC')->distinct('percentage_target')->pluck('percentage_target')->toArray();
        $this->target_percentage_ceramic = PercentageRegionCommission::where('type', 'ceramic')->orderBy('percentage_target', 'DESC')->distinct('percentage_target')->pluck('percentage_target')->toArray();
        $this->payment_percentage = [
            100 => 'Ontime',
            50  => 'Lebih 16 - 22 Hari',
            0   => 'Hangus'
        ];
        $this->roof_datas    = RegionCommission::where('month', $month)->where('sales_type', 'roof')->get();
        $this->ceramic_datas = RegionCommission::where('month', $month)->where('sales_type', 'ceramic')->get();
    }

    public function exportData()
    {
        return Excel::download(new RegionCommissionExport($this->month), 'Komisi Wilayah ' . Carbon::parse($this->month)->format('Y-m') . '.xlsx');
    }
}
