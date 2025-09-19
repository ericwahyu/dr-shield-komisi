<?php

namespace App\Services\Commission;

use Carbon\Carbon;
use App\Models\Invoice\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice\InvoiceDetail;
use App\Models\Commission\RegionCommission;
use App\Models\System\PercentageRegionCommission;
use App\Traits\GetSystemSetting;

class RegionCommissionService
{
    /**
     * Create a new class instance.
     */
    use GetSystemSetting;

    public $percentage;

    public function __construct()
    {
        //
        $percentage_roofs    = PercentageRegionCommission::where('type', 'roof')->orderBy('percentage_target', 'DESC')->pluck('percentage_commission', 'percentage_target')->toArray();
        $percentage_ceramics = PercentageRegionCommission::where('type', 'ceramic')->orderBy('percentage_target', 'DESC')->pluck('percentage_commission', 'percentage_target')->toArray();

        // $this->percentage    = [
        //     'roof' => [
        //         100 => 0.30,
        //         90  => 0.25,
        //         80  => 0.2,
        //         70  => 0.15,
        //     ],
        //     'ceramic' => [
        //         100 => 0.35,
        //         90  => 0.30,
        //         80  => 0.25,
        //         70  => 0.20,
        //     ]
        // ];

        $this->percentage    = [
            'roof'    => $percentage_roofs,
            'ceramic' => $percentage_ceramics
        ];
    }

    public function generate($request)
    {
        foreach ($request['datas']['roof'] ?? [] as $key_roof => $roof) {
            foreach ($this->percentage['roof'] ?? [] as $key_percentage => $percentage) {
                $request['datas']['roof'][$key_roof][$key_percentage] = $request['datas']['roof'][$key_roof][100] * $key_percentage / 100;
            }
        }

        foreach ($request['datas']['ceramic'] ?? [] as $key_ceramic => $ceramic) {
            foreach ($this->percentage['ceramic'] ?? [] as $key_percentage => $percentage) {
                $request['datas']['ceramic'][$key_ceramic][$key_percentage] = $request['datas']['ceramic'][$key_ceramic][100] * $key_percentage / 100;
            }
        }

        return $this->generateRegionCommission($request);
    }

    //ROOF
    private function generateRegionCommission($request)
    {
        foreach ($request['datas'] ?? [] as $key_data => $data) {
            foreach ($data ?? [] as $key_type => $value_type) {
                DB::beginTransaction();
                    $region_commission = RegionCommission::updateOrCreate(
                        [
                            'month'       => $request['date'],
                            'sales_type' => $key_data,
                            'depo'       => $key_type,
                        ],
                        [
                            'user_id'          => Auth::user()?->id,
                            'targets'          => json_encode($value_type, true),
                            'total_income_tax' => $this->totalIncomeTax($request['date'], $key_data, $key_type)
                        ]
                    );

                    $getpercentageTarget = $this->getpercentageTarget($region_commission);
                    // dd($this->getAmountInvoiceDetail($region_commission, $request['date'], $key_data, $key_type));
                    $region_commission->update([
                        'percentage_target'     => $getpercentageTarget,
                        'percentage_commission' => isset($this->percentage[$key_type][$getpercentageTarget]) ? $this->percentage[$key_type][$getpercentageTarget] : null,
                        'payments'              => $getpercentageTarget ? $this->getAmountInvoiceDetail($region_commission, $request['date'], $key_data, $key_type)[0] : null,
                        'value_commission'      => $getpercentageTarget ? $this->getAmountInvoiceDetail($region_commission, $request['date'], $key_data, $key_type)[1] : 0,
                    ]);
                DB::commit();
            }
        }
    }

    private function totalIncomeTax($month, $sales_type, $depo)
    {
        // $total_income_tax = Invoice::whereHas('user', function ($query) use ($sales_type, $depo) {
        //     $query->whereHas('userDetail', function ($query) use ($sales_type, $depo) {
        //             $query->where('sales_type', $sales_type)->where('depo', $depo);
        //             // $query->where('sales_type', 'roof')->where('depo', 'BDG');
        //         })
        //         ->where('status', 'active');
        //         // ->where('name', 'Online');
        // })->whereYear('date', Carbon::parse($month)->year)->whereMonth('date', Carbon::parse($month)->month)->whereNotNull('customer')->whereNotNull('id_customer')->sum('income_tax');

        $total_income_tax = Invoice::join('users', 'invoices.user_id', '=', 'users.id')
            ->join('user_details', 'users.id', '=', 'user_details.user_id')
            ->where('user_details.sales_type', $sales_type)
            ->where('user_details.depo', $depo)
            ->where('users.status', 'active')
            ->whereYear('invoices.date', Carbon::parse($month)->year)
            ->whereMonth('invoices.date', Carbon::parse($month)->month)
            ->whereNotNull('invoices.customer')
            ->whereNotNull('invoices.id_customer')
            ->sum('invoices.income_tax');

        return (int)$total_income_tax;
    }

    private function getpercentageTarget($region_commission)
    {
        $targets          = $region_commission?->targets ? json_decode($region_commission?->targets, true) : [];
        $total_income_tax = $region_commission?->total_income_tax ?? 0;
        krsort($targets);

        $nextKey = null;
        foreach ($targets as $key => $value) {
            if ($total_income_tax == $value) {
                return null; // kalau sama persis return null
            }

            if ($total_income_tax > $value) {
                return $key;
            }

            $nextKey = $key;
        }

        return null;
    }

    private function getAmountInvoiceDetail($region_commission, $month, $sales_type, $depo)
    {
        $datas = [100, 50]; //mengambil percentage amount dari invoice detail

        $payments = []; $value_commission = 0;

        foreach ($datas as $key => $data) {
            // if ($data == 100) continue;
            // $amount = InvoiceDetail::whereHas('invoice.user', function ($query) use ($sales_type, $depo) {
            //     $query->whereHas('userDetail', function ($query) use ($sales_type, $depo) {
            //         $query->where('sales_type', $sales_type)->where('depo', $depo);
            //         // $query->where('sales_type', 'roof')->where('depo', 'SKB');
            //     })
            //     ->where('status', 'active');
            //     // ->where('name', 'Yogi Permana');
            // })->whereYear('date', Carbon::parse($month)->year)->whereMonth('date', Carbon::parse($month)->month)->where('percentage', $data)->where('version', 2)->sum('amount');

            $amount = InvoiceDetail::query()
                ->join('invoices', 'invoice_details.invoice_id', '=', 'invoices.id')
                ->join('users', 'invoices.user_id', '=', 'users.id')
                ->join('user_details', 'users.id', '=', 'user_details.user_id')
                ->where('user_details.sales_type', $sales_type)
                ->where('user_details.depo', $depo)
                ->where('users.status', 'active')
                ->whereYear('invoice_details.date', Carbon::parse($month)->year)
                ->whereMonth('invoice_details.date', Carbon::parse($month)->month)
                ->where('invoice_details.percentage', $data)
                ->where('invoice_details.version', 2)
                ->sum('invoice_details.amount');

            $amount = round($amount / floatval($this->getSystemSetting()?->value_of_total_income) , 0);

            $getpercentageTarget   = $this->getpercentageTarget($region_commission);
            $percentage_commission = isset($this->percentage[$sales_type][$getpercentageTarget]) ? $this->percentage[$sales_type][$getpercentageTarget] : null;

            // dd($percentage_commission, $depo, $getpercentageTarget, $this->percentage);
            $payments[$data] = [
                'total_amount' => (int)$amount ? (int)$amount * $data / 100 : 0,
                'commission'   => ((int)$amount *  $data / 100) * ($percentage_commission / 100) ?? 0
            ];

            $value_commission += $payments[$data]['commission'];
        }

        return [json_encode($payments, true), (int)$value_commission];
    }
}
