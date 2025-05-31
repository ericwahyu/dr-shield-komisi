<?php

namespace App\Exports\Commission\RoofCommission;

use Carbon\Carbon;
use App\Models\Auth\User;
use App\Models\System\Category;
use Illuminate\Contracts\View\View;
use App\Models\Commission\Commission;
use App\Services\Export\Commission\ExportRoofCommissionVersion2;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class RoofCommissionVersion2 implements FromView
{
     protected $export_month, $ExportRoofCommissionVersion2;

    function __construct($export_month)
    {
        $this->export_month = $export_month;
        $this->ExportRoofCommissionVersion2 = new ExportRoofCommissionVersion2($export_month);
    }

    public function view(): View
    {
        $categories = [null, 'dr-sonne'];
        $sales      = User::role('sales')->whereHas('userDetail', function ($query) {
                        $query->where('sales_type', 'roof');
                    })->get();

        return view('layouts.export.roof-commission-version-2', [
            'categories' => $categories,
            'sales'      => $sales,
            'service'    => $this->ExportRoofCommissionVersion2
        ]);
    }
}
