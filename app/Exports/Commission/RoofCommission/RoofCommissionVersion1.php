<?php

namespace App\Exports\Commission\RoofCommission;

use App\Models\Auth\User;
use App\Models\System\Category;
use App\Services\Export\Commission\ExportRoofCommissionVersion1;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class RoofCommissionVersion1 implements FromView
{
    protected $export_month, $ExportRoofCommissionVersion1;

    public function __construct($export_month)
    {
        $this->export_month = $export_month;
        $this->ExportRoofCommissionVersion1 = new ExportRoofCommissionVersion1($export_month);
    }

    public function view(): View
    {
        $categories = Category::where('type', 'roof')->where('version', 1)->get();
        $sales      = User::role('sales')->whereHas('userDetail', function ($query) {
                        $query->where('sales_type', 'roof');
                    })->get();

        return view('layouts.export.roof-commission-version-1', [
            'categories' => $categories,
            'sales'      => $sales,
            'service'    => $this->ExportRoofCommissionVersion1
        ]);
    }
}
