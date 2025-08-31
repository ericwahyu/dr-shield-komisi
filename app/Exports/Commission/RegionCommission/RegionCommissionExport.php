<?php

namespace App\Exports\Commission\RegionCommission;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Commission\RegionCommission;
use Maatwebsite\Excel\Concerns\FromCollection;

class RegionCommissionExport implements FromView
{
    protected $export_month;

    public function __construct($export_month)
    {
        $this->export_month = $export_month;
    }

    public function view(): View
    {
        //
        $month = Carbon::parse($this->export_month)->format('Y-m');
        $target_percentage = [100, 90, 80, 70];
        $payment_percentage = [
            100 => 'Ontime',
            50  => 'Lebih 16 - 22 Hari',
            0   => 'Hangus'
        ];
        $roof_datas    = RegionCommission::where('month', $month)->where('sales_type', 'roof')->get();
        $ceramic_datas = RegionCommission::where('month', $month)->where('sales_type', 'ceramic')->get();

        return view('layouts.export.region-commission', [
            'target_percentage'  => $target_percentage,
            'payment_percentage' => $payment_percentage,
            'roof_datas'         => $roof_datas,
            'ceramic_datas'      => $ceramic_datas,
        ]);
    }
}
