<?php

namespace App\Exports\Commission\CeramicCommission;

use App\Models\Auth\User;
use App\Services\Export\Commission\Ceramic\ExportCeramicCommissionVersion1;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CeramicCommissionVersion1 implements FromView
{
    protected $export_month, $ExportCeramicCommissionVersion1;

    public function __construct($export_month)
    {
        $this->export_month = $export_month;
        $this->ExportCeramicCommissionVersion1 = new ExportCeramicCommissionVersion1($export_month);
    }

    public function view(): View
    {
        $sales = User::role('sales')->whereHas('userDetail', function ($query) {
                        $query->where('sales_type', 'ceramic');
                    })->get()->sortBy(fn ($user) => $user->userDetail->depo);

        return view('layouts.export.ceramic.ceramic-commission-version-1', [
            // 'categories' => $categories,
            'sales'      => $sales,
            'service'    => $this->ExportCeramicCommissionVersion1
        ]);
    }
}
