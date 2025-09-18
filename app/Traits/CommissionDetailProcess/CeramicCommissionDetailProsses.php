<?php

namespace App\Traits\CommissionDetailProcess;

use App\Models\Auth\User;
use App\Models\Commission\Commission;
use App\Models\Invoice\InvoiceDetail;
use App\Traits\GetSystemSetting;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

trait CeramicCommissionDetailProsses
{
    //
    use GetSystemSetting;

    public function _ceramicCommissionDetail($invoice, $datas)
    {
        try {
            if ($datas['version'] == 1) {
                $this->_ceramicCommissionDetailV1($invoice, $datas);
            } elseif ($datas['version'] == 2) {
                $this->_ceramicCommissionDetailV2($invoice, $datas);
            }

        } catch (Exception | Throwable $th) {
            Log::error("Ada kesalahan proses detail komisi keramik");
            throw new Exception($th->getMessage());
        }
    }

    private function _ceramicCommissionDetailV1($invoice, $datas)
    {
        try {
            $get_commission = Commission::where('user_id', $invoice?->user?->id)->where('year', (int)$invoice?->date?->format('Y'))->where('month', (int)$invoice?->date?->format('m'))->where('version', $datas['version'])->whereNull('category_id')->first();
            if ($get_commission) {
                if (count($get_commission->lowerLimitCommissions) < 1) {
                    $lower_limit_ceramics = User::find($invoice?->user?->id)->lowerLimits()->where('version', $datas['version'])->whereNull('category_id')->get();
                    foreach ($lower_limit_ceramics as $key => $lower_limit_ceramic) {
                        $get_commission->lowerLimitCommissions()->orderBy('value', 'DESC')->create([
                            'lower_limit_id' => $lower_limit_ceramic?->id,
                            'target_payment' => (int)$lower_limit_ceramic?->target_payment,
                            'value'          => $lower_limit_ceramic?->value,
                        ]);
                    }
                }

                $invoice_details = InvoiceDetail::whereHas('invoice', function ($query) use ($invoice) {
                    $query->whereYear('date', (int)$invoice?->date?->format('Y'))->whereMonth('date', (int)$invoice?->date?->format('m'))
                        ->where('user_id', $invoice?->user?->id);
                })->where('version', $datas['version']);

                foreach ($invoice_details->distinct()->pluck('percentage')->toArray() as $key => $percentage_invoice_details) {

                    foreach ($invoice_details
                    // ->selectRaw('YEAR(date) as year, MONTH(date) as month')->groupBy('year', 'month')
                    ->selectRaw('EXTRACT(YEAR FROM date) AS year, EXTRACT(MONTH FROM date) AS month')
                    ->distinct()
                    ->get()
                    ->map(function ($item) {
                        return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
                    })
                    ->toArray() as $key => $year_month_invoice_detail) {

                        $total_income = InvoiceDetail::whereHas('invoice', function ($query) use ($invoice) {
                            $query->whereYear('date', (int)$invoice?->date?->format('Y'))->whereMonth('date', (int)$invoice?->date?->format('m'))->where('user_id', $invoice?->user?->id);
                        })->whereYear('date', (int)Carbon::parse($year_month_invoice_detail)->format('Y'))->whereMonth('date', (int)Carbon::parse($year_month_invoice_detail)->format('m'))->where('percentage', (int)$percentage_invoice_details)->where('version', $datas['version'])->sum('amount');

                        $get_commission->commissionDetails()->updateOrCreate(
                            [
                                'year'                   => (int)Carbon::parse($year_month_invoice_detail)->format('Y'),
                                'month'                  => (int)Carbon::parse($year_month_invoice_detail)->format('m'),
                                'percentage_of_due_date' => $percentage_invoice_details
                            ],
                            [
                                'total_income'      => round((int)$total_income/floatval($this->getSystemSetting()?->value_of_total_income)*((int)$percentage_invoice_details > 0 ? (int)$percentage_invoice_details/100 : 1), 2),
                                'value_of_due_date' => $get_commission?->percentage_value_commission != null ? round(round((int)$total_income/floatval($this->getSystemSetting()?->value_of_total_income)*((int)$percentage_invoice_details/100), 2) * ($get_commission?->percentage_value_commission/100), 0) : null
                            ]
                        );
                    }
                }

                if ($get_commission->commissionDetails()->whereNot('percentage_of_due_date', 0)->sum('value_of_due_date') > 0) {
                    $get_commission->update([
                        'value_commission' => $get_commission->commissionDetails()->whereNot('percentage_of_due_date', 0)->sum('value_of_due_date')
                    ]);
                }

                if ($get_commission?->percentage_value_commission != null) {
                    foreach ($get_commission?->commissionDetails()->get() as $key => $commission_detail) {
                        $commission_detail->update([
                            'value_of_due_date' => round((int)$commission_detail?->total_income / floatval($this->getSystemSetting()?->value_of_total_income) * ($get_commission?->percentage_value_commission/100), 0)
                        ]);
                    }
                }
            }
        } catch (Exception | Throwable $th) {
            Log::error("Ada kesalahan saat proses detail komisi keramik v1");
            throw new Exception($th->getMessage());
        }
    }

    private function _ceramicCommissionDetailV2($invoice, $datas)
    {
        try {
            //code...
            $get_commission = Commission::where('user_id', $invoice?->user?->id)->where('year', (int)Carbon::parse($datas['invoice_detail_date'])?->format('Y'))->where('month', (int)Carbon::parse($datas['invoice_detail_date'])?->format('m'))->where('version', $datas['version'])->whereNull('category_id')->first();
            if ($get_commission) {
                if (count($get_commission->lowerLimitCommissions) < 1) {
                    $lower_limit_ceramics = User::find($invoice?->user?->id)->lowerLimits()->where('version', $datas['version'])->whereNull('category_id')->get();
                    foreach ($lower_limit_ceramics as $key => $lower_limit_ceramic) {
                        $get_commission->lowerLimitCommissions()->orderBy('value', 'DESC')->create([
                            'lower_limit_id' => $lower_limit_ceramic?->id,
                            'target_payment' => (int)$lower_limit_ceramic?->target_payment,
                            'value'          => $lower_limit_ceramic?->value,
                        ]);
                    }
                }

                $invoice_details = InvoiceDetail::whereHas('invoice', function ($query) use ($invoice) {
                    $query->where('user_id', $invoice?->user?->id);
                })->whereYear('date', (int)Carbon::parse($datas['invoice_detail_date'])?->format('Y'))->whereMonth('date', (int)Carbon::parse($datas['invoice_detail_date'])?->format('m'))->where('version', $datas['version']);

                foreach ($invoice_details->distinct()->pluck('percentage')->toArray() as $key => $percentage_invoice_details) {

                    foreach ($invoice_details
                    // ->selectRaw('YEAR(date) as year, MONTH(date) as month')->groupBy('year', 'month')
                    ->selectRaw('EXTRACT(YEAR FROM date) AS year, EXTRACT(MONTH FROM date) AS month')
                    ->distinct()
                    ->get()
                    ->map(function ($item) {
                        return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
                    })
                    ->toArray() as $key => $year_month_invoice_detail) {

                        $total_income = InvoiceDetail::whereHas('invoice', function ($query) use ($invoice) {
                            $query->where('user_id', $invoice?->user?->id);
                        })->whereYear('date', (int)Carbon::parse($year_month_invoice_detail)->format('Y'))->whereMonth('date', (int)Carbon::parse($year_month_invoice_detail)->format('m'))->where('percentage', (int)$percentage_invoice_details)->where('version', $datas['version'])->sum('amount');

                        $get_commission->commissionDetails()->updateOrCreate(
                            [
                                'year'                   => (int)Carbon::parse($year_month_invoice_detail)->format('Y'),
                                'month'                  => (int)Carbon::parse($year_month_invoice_detail)->format('m'),
                                'percentage_of_due_date' => $percentage_invoice_details
                            ],
                            [
                                'total_income'      => round((int)$total_income/floatval($this->getSystemSetting()?->value_of_total_income)*((int)$percentage_invoice_details > 0 ? (int)$percentage_invoice_details/100 : 1), 2),
                                'value_of_due_date' => (int)$get_commission?->percentage_value_commission != null && $percentage_invoice_details > 0 ? round(round((int)$total_income/floatval($this->getSystemSetting()?->value_of_total_income)*((int)$percentage_invoice_details/100), 2) * ($get_commission?->percentage_value_commission/100), 0) : null
                            ]
                        );
                    }
                }

                if ($get_commission?->percentage_value_commission != null) {

                        $value_salesman = array(
                            70  => 0.4,
                            80  => 0.5,
                            90  => 0.6,
                            100 => 0.7,
                        );

                        $percentage_value_commission = $value_salesman[$get_commission?->percentage_value_commission] ?? 0;

                    foreach ($get_commission?->commissionDetails()->get() as $key => $commission_detail) {
                        $commission_detail->update([
                            'value_of_due_date' => $commission_detail?->percentage_of_due_date > 0 ? round((int)$commission_detail?->total_income * ($percentage_value_commission/100), 0) : null
                        ]);
                    }
                }

                if ($get_commission->commissionDetails()->whereNot('percentage_of_due_date', 0)->sum('value_of_due_date') > 0) {
                    $get_commission->update([
                        'value_commission' => $get_commission->commissionDetails()->whereNot('percentage_of_due_date', 0)->sum('value_of_due_date')
                    ]);
                }

            } else {
                $commission = Commission::create([
                    'user_id'     => $invoice?->user?->id,
                    'month'       => Carbon::parse($datas['invoice_detail_date'])->format('m'),
                    'year'        => Carbon::parse($datas['invoice_detail_date'])->format('Y'),
                    'version'     => $datas['version'],
                    // 'total_sales' => (int)$datas['income_tax'],
                    'status'      => 'not-reach'
                ]);

                if (count($commission->lowerLimitCommissions) < 1) {
                    $lower_limit_ceramics = User::find($invoice?->user?->id)->lowerLimits()->where('version', $datas['version'])->whereNull('category_id')->get();
                    foreach ($lower_limit_ceramics as $key => $lower_limit_ceramic) {
                        $commission->lowerLimitCommissions()->orderBy('value', 'DESC')->create([
                            'lower_limit_id' => $lower_limit_ceramic?->id,
                            'target_payment' => (int)$lower_limit_ceramic?->target_payment,
                            'value'          => $lower_limit_ceramic?->value,
                        ]);
                    }
                }
            }
        } catch (Exception | Throwable $th) {
            Log::error("Ada kesalahan saat proses detail komisi keramik v2");
            throw new Exception($th->getMessage());
        }
    }
}
