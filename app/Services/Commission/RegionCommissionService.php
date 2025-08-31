<?php

namespace App\Services\Commission;

use App\Models\Commission\RegionCommission;
use App\Models\Invoice\Invoice;
use App\Models\Invoice\InvoiceDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegionCommissionService
{
    /**
     * Create a new class instance.
     */
    public $percentage;

    public function __construct()
    {
        //
        $this->percentage = [
            'roof' => [
                100 => 0.30,
                90  => 0.25,
                80  => 0.2,
                70  => 0.15,
            ]
        ];
    }

    public function generate($request)
    {
        foreach ($request['datas']['roof'] ?? [] as $key_roof => $roof) {
            foreach ($this->percentage['roof'] ?? [] as $key_percentage => $percentage) {
                $request['datas']['roof'][$key_roof][$key_percentage] = $request['datas']['roof'][$key_roof][100] * $key_percentage / 100;
            }
        }
        return $this->generateRegionCommissionRoof($request);
    }

    //ROOF
    public function generateRegionCommissionRoof($request)
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
                            'total_income_tax' => $this->totalIncomeTaxRoof($request['date'], $key_data, $key_type)
                        ]
                    );

                    // dd($this->getpercentageTarget($region_commission));
                    $getpercentageTarget = $this->getpercentageTargetRoof($region_commission);
                    $region_commission->update([
                        'percentage_target'     => $getpercentageTarget,
                        'percentage_commission' => isset($this->percentage['roof'][$getpercentageTarget]) ? $this->percentage['roof'][$getpercentageTarget] : null,
                        'payments'              => $getpercentageTarget ? $this->getAmountInvoiceDetail($region_commission, $request['date'], $key_data, $key_type)[0] : null,
                        'value_commission'      => $getpercentageTarget ? $this->getAmountInvoiceDetail($region_commission, $request['date'], $key_data, $key_type)[1] : 0,
                    ]);
                DB::commit();
            }
        }
    }

    private function totalIncomeTaxRoof($month, $sales_type, $depo)
    {
        $total_income_tax = Invoice::whereHas('user', function ($query) use ($sales_type, $depo) {
            $query->whereHas('userDetail', function ($query) use ($sales_type, $depo) {
                    $query->where('sales_type', $sales_type)->where('depo', $depo);
                    // $query->where('sales_type', 'roof')->where('depo', 'BDG');
                });
                // ->where('name', 'Online');
        })->whereYear('date', Carbon::parse($month)->year)->whereMonth('date', Carbon::parse($month)->month)->whereNotNull('customer')->whereNotNull('id_customer')->sum('income_tax');

        // dd($month, $sales_type, $depo, (int)$total_income_tax);

        return (int)$total_income_tax;
    }

    private function getpercentageTargetRoof($region_commission)
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
            $amount = InvoiceDetail::whereHas('invoice.user', function ($query) use ($sales_type, $depo) {
                $query->whereHas('userDetail', function ($query) use ($sales_type, $depo) {
                    $query->where('sales_type', $sales_type)->where('depo', $depo);
                    // $query->where('sales_type', 'roof')->where('depo', 'SKB');
                })
                ->where('name', 'Yogi Permana');
            })->whereYear('date', Carbon::parse($month)->year)->whereMonth('date', Carbon::parse($month)->month)->where('percentage', $data)->where('version', 2)->sum('amount');
            
            $payments[$data] = [
                'total_amount' => (int)$amount ? (int)$amount * $data / 100 : 0,
                'commission'   => ((int)$amount *  $data / 100) * ($region_commission?->percentage_commission / 100) ?? 0
            ];
            
            dd($data, $sales_type, $depo, (int)$amount, $payments);

            $value_commission += $payments[$data]['commission'];
        }

        return [json_encode($payments, true), (int)$value_commission];
    }
}
