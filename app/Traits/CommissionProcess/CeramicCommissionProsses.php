<?php

namespace App\Traits\CommissionProcess;

use App\Models\Auth\User;
use App\Models\Commission\Commission;
use App\Models\Invoice\Invoice;
use App\Traits\GetSystemSetting;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

trait CeramicCommissionProsses
{
    //
    use GetSystemSetting;

    public function _ceramicCommission($invoice, $datas)
    {
        try {
            $get_commission = Commission::where('user_id', $invoice?->user?->id)->where('month', (int)$invoice?->date?->format('m'))->where('year', (int)$invoice?->date?->format('Y'))->where('version', $datas['version'])->whereNull('category_id')->first();
            if (!$get_commission) {
                $commission = Commission::create([
                    'user_id'     => $invoice?->user?->id,
                    'month'       => $invoice?->date?->format('m'),
                    'year'        => $invoice?->date?->format('Y'),
                    'version'     => $datas['version'],
                    'total_sales' => (int)$datas['income_tax'],
                    'status'      => 'not-reach'
                ]);

                if (count($commission->lowerLimitCommissions) < 1) {
                    $lower_limit_ceramics = User::find($invoice?->user?->id)->lowerLimits()->where('version', $datas['version'])->whereNull('category_id')->get();
                    foreach ($lower_limit_ceramics as $key => $lower_limit_ceramic) {
                        $commission->lowerLimitCommissions()->orderBy('value', 'DESC')->create([
                            'lower_limit_id' => $lower_limit_ceramic?->id,
                            'target_payment' => $lower_limit_ceramic?->target_payment,
                            'value'          => $lower_limit_ceramic?->value,
                        ]);
                    }
                }
            } else {
                if (count($get_commission->lowerLimitCommissions) < 1) {
                    $lower_limit_ceramics = User::find($invoice?->user?->id)->lowerLimits()->where('version', $datas['version'])->whereNull('category_id')->get();
                    foreach ($lower_limit_ceramics as $key => $lower_limit_ceramic) {
                        $get_commission->lowerLimitCommissions()->orderBy('value', 'DESC')->create([
                            'lower_limit_id' => $lower_limit_ceramic?->id,
                            'target_payment' => $lower_limit_ceramic?->target_payment,
                            'value'          => $lower_limit_ceramic?->value,
                        ]);
                    }
                }

                $sum_income_tax = Invoice::whereHas('user', function ($query) use ($invoice) {
                    $query->where('id', $invoice?->user?->id);
                })->whereYear('date', (int)$invoice?->date->format('Y'))->whereMonth('date', (int)$invoice?->date->format('m'))->where('type', 'ceramic')->sum('income_tax');

                $sum_income_tax_2 = Invoice::whereHas('user', function ($query) use ($invoice) {
                    $query->where('id', $invoice?->user?->id);
                })->whereYear('date', (int)$invoice?->date->format('Y'))->whereMonth('date', (int)$invoice?->date->format('m'))->where('type', 'ceramic')->whereNotNull('customer')->whereNotNull('id_customer')->sum('income_tax');

                if ($datas['version'] == 1) {
                    $this->_ceramicCommissionV1($get_commission, $sum_income_tax);
                } elseif ($datas['version'] == 2) {
                    $this->_ceramicCommissionV2($get_commission, $sum_income_tax_2);
                }
            }
        } catch (Exception | Throwable $th) {
            Log::error("Ada kesalahan saat proses komisi keramik");
            throw new Exception($th->getMessage());
        }
    }

    private function _ceramicCommissionV1($get_commission, $sum_income_tax)
    {
        try {
            $get_lower_limit_commission = $get_commission?->lowerLimitCommissions()->whereNull('category_id')->where('target_payment', '<=', (int)$sum_income_tax)->max('value');
            $get_lower_limit_commission = $get_lower_limit_commission != null && $get_lower_limit_commission >= 0.3 ? $get_lower_limit_commission + $this->getSystemSetting()?->value_incentive : $get_lower_limit_commission;

            $get_commission?->update([
                'total_sales'                 => $sum_income_tax,
                'percentage_value_commission' => $get_lower_limit_commission,
                'status'                      => $get_lower_limit_commission != null ? 'reached' : 'not-reach'
            ]);

            if ($get_commission?->percentage_value_commission != null) {
                foreach ($get_commission?->commissionDetails()->get() as $key => $commission_detail) {
                    $commission_detail->update([
                        'value_of_due_date' => (int)($commission_detail?->total_income * ($get_commission?->percentage_value_commission/100))
                    ]);
                }
            }

            if ($get_commission->commissionDetails()->whereNot('percentage_of_due_date', 0)->sum('value_of_due_date') > 0) {
                $get_commission->update([
                    'value_commission' => $get_commission->commissionDetails()->whereNot('percentage_of_due_date', 0)->sum('value_of_due_date')
                ]);
            }

        } catch (Exception | Throwable $th) {
            Log::error("Ada kesalahan saat proses komisi keramik v1");
            throw new Exception($th->getMessage());
        }
    }

    private function _ceramicCommissionV2($get_commission, $sum_income_tax)
    {
        try {
            $get_lower_limit_commission = $get_commission?->lowerLimitCommissions()->whereNull('category_id')->where('target_payment', '<=', (int)$sum_income_tax)->max('value');

            $get_commission?->update([
                'total_sales'                 => $sum_income_tax,
                'percentage_value_commission' => $get_lower_limit_commission,
                'status'                      => $get_lower_limit_commission != null ? 'reached' : 'not-reach'
            ]);

            if ($get_commission?->percentage_value_commission != null) {

                $value_salesman = array(
                    70  => 0.5,
                    80  => 0.5,
                    90  => 0.7,
                    100 => 0.8,
                );

                $percentage_value_commission = $value_salesman[$get_commission?->percentage_value_commission] ?? 0;

                foreach ($get_commission?->commissionDetails()->get() as $key => $commission_detail) {
                    $commission_detail->update([
                        'value_of_due_date' => (int)($commission_detail?->total_income * ($percentage_value_commission/100))
                    ]);
                }
            }

            if ($get_commission->commissionDetails()->whereNot('percentage_of_due_date', 0)->sum('value_of_due_date') > 0) {
                $get_commission->update([
                    'value_commission' => $get_commission->commissionDetails()->whereNot('percentage_of_due_date', 0)->sum('value_of_due_date')
                ]);
            }
        } catch (Exception | Throwable $th) {
            Log::error("Ada kesalahan saat proses komisi keramik v2");
            throw new Exception($th->getMessage());
        }
    }
}
