<?php

namespace App\Traits\CommissionProcess;

use App\Models\Auth\User;
use App\Models\Commission\Commission;
use App\Models\Invoice\PaymentDetail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

trait RoofCommissionProsses
{
    //
    public function _roofCommission($invoice, $category, $datas)
    {
        try {
            if ($datas['version'] == 1) {
                $this->_roofCommissionV1($invoice, $category, $datas);
            } elseif ($datas['version'] == 2) {
                $this->_roofCommissionV2($invoice, $category, $datas);
            }
        } catch (Exception | Throwable $th) {
            $error = [
                'message' => $th->getMessage(),
                'file'    => $th->getFile(),
                'line'    => $th->getLine(),
            ];
            Log::error("Ada kesalahan saat proses payment detail atap", $error);
            throw new \Exception($th->getMessage());
            // throw new \Exception(json_encode([
            //     'error_message' => $th->getMessage(),
            //     'file'          => $th->getFile(),
            //     'line'          => $th->getLine(),
            // ]));
        }
    }

    private function _roofCommissionV1($invoice, $category, $datas)
    {
        try {
            $get_commission = Commission::where('user_id', $invoice?->user?->id)->where('month', (int)$invoice?->date?->format('m'))->where('year', (int)$invoice?->date?->format('Y'))->where('category_id', $category?->id)->where('version', 1)->first();
            if (!$get_commission) {
                $commission = Commission::create([
                    'user_id'     => $invoice?->user?->id,
                    'category_id' => $category?->id,
                    'version'     => 1,
                    'month'       => $invoice?->date?->format('m'),
                    'year'        => $invoice?->date?->format('Y'),
                    'total_sales' => $invoice?->paymentDetails()->where('category_id', $category?->id)->sum('amount'),
                    'status'      => 'not-reach'
                ]);

                if (count($commission->lowerLimitCommissions) == 0) {
                    $lower_limit_ceramics = User::find($invoice?->user?->id)->lowerLimits()->where('version', 1)->where('category_id', $category?->id)->get();
                    foreach ($lower_limit_ceramics as $key => $lower_limit_ceramic) {
                        $commission->lowerLimitCommissions()->create([
                            'lower_limit_id' => $lower_limit_ceramic?->id,
                            'category_id'    => $category?->id,
                            'target_payment' => $lower_limit_ceramic?->target_payment,
                            'value'          => $lower_limit_ceramic?->value,
                        ]);
                    }
                }
            } else {
                if (count($get_commission->lowerLimitCommissions) == 0) {
                    $lower_limit_ceramics = User::find($invoice?->user?->id)->lowerLimits()->where('category_id', $category?->id)->get();
                    foreach ($lower_limit_ceramics as $key => $lower_limit_ceramic) {
                        $get_commission->lowerLimitCommissions()->create([
                            'lower_limit_id' => $lower_limit_ceramic?->id,
                            'category_id'    => $category?->id,
                            'target_payment' => $lower_limit_ceramic?->target_payment,
                            'value'          => $lower_limit_ceramic?->value,
                        ]);
                    }
                }
                $sum_income_tax = PaymentDetail::whereHas('invoice', function ($query) use ($invoice) {
                    $query->whereHas('user', function ($query) use ($invoice) {
                        $query->where('id', $invoice?->user?->id);
                    })->whereYear('date', (int)$invoice?->date->format('Y'))->whereMonth('date', (int)$invoice?->date->format('m'))->where('type', 'roof');
                })->where('category_id', $category?->id)->sum('income_tax');

                $get_lower_limit_commission = $get_commission?->lowerLimitCommissions()->where('category_id', $category?->id)->where('target_payment', '<=', (int)$sum_income_tax)->max('value');
                $get_lower_limit_commission = $get_lower_limit_commission ?? null;

                $get_commission?->update([
                    'total_sales'                 => $sum_income_tax,
                    'percentage_value_commission' => $get_lower_limit_commission,
                    'status'                      => $get_lower_limit_commission != null ? 'reached' : 'not-reach'
                ]);

                if ($get_commission?->percentage_value_commission != null) {
                    foreach ($get_commission?->commissionDetails()->get() as $key => $commission_detail) {
                        $commission_detail->update([
                            'value_of_due_date' => intval($commission_detail?->total_income * ($get_commission?->percentage_value_commission/100))
                        ]);
                    }
                }

                if ($get_commission->commissionDetails()->whereNot('percentage_of_due_date', 0)->sum('value_of_due_date') > 0) {
                    $get_commission->update([
                        'value_commission' => $get_commission->commissionDetails()->whereNot('percentage_of_due_date', 0)->sum('value_of_due_date')
                    ]);
                }
            }
        } catch (Exception | Throwable $th) {
            $error = [
                'message' => $th->getMessage(),
                'file'    => $th->getFile(),
                'line'    => $th->getLine(),
            ];
            Log::error("Ada kesalahan saat proses payment detail atap v1", $error);
            throw new \Exception($th->getMessage());
        }
    }

    private function _roofCommissionV2($invoice, $category, $datas)
    {
        try {
            $get_commission = Commission::where('user_id', $invoice?->user?->id)->where('month', (int)$invoice?->date?->format('m'))->where('year', (int)$invoice?->date?->format('Y'))
            ->when($category != null, function ($query) use ($category) {
                $query->where('category_id', $category?->id);
            })
            ->when($category == null, function ($query) use ($category) {
                $query->whereNull('category_id');
            })
            ->where('version', 2)->first();

            if (!$get_commission) {
                $commission = Commission::create([
                    'user_id'     => $invoice?->user?->id,
                    'category_id' => $category?->id,
                    'version'     => 2,
                    'month'       => $invoice?->date?->format('m'),
                    'year'        => $invoice?->date?->format('Y'),
                    'total_sales' => $invoice?->paymentDetails()->where('category_id', $category?->id)->sum('amount'),
                    'status'      => 'not-reach'
                ]);

                if (count($commission->lowerLimitCommissions) == 0) {
                    $lower_limit_ceramics = User::find($invoice?->user?->id)->lowerLimits()->where('version', 2) ->when($category != null, function ($query) use ($category) {
                        $query->where('category_id', $category?->id);
                    })
                    ->when($category == null, function ($query) use ($category) {
                        $query->whereNull('category_id');
                    })->get();


                    foreach ($lower_limit_ceramics as $key => $lower_limit_ceramic) {
                        $commission->lowerLimitCommissions()->create([
                            'lower_limit_id' => $lower_limit_ceramic?->id,
                            'category_id'    => $category?->id,
                            'target_payment' => $lower_limit_ceramic?->target_payment,
                            'value'          => $lower_limit_ceramic?->value,
                        ]);
                    }
                }
            } else {
                if (count($get_commission->lowerLimitCommissions) == 0) {
                    $lower_limit_ceramics = User::find($invoice?->user?->id)->lowerLimits() ->when($category != null, function ($query) use ($category) {
                        $query->where('category_id', $category?->id);
                    })
                    ->when($category == null, function ($query) use ($category) {
                        $query->whereNull('category_id');
                    })->get();

                    foreach ($lower_limit_ceramics as $key => $lower_limit_ceramic) {
                        $get_commission->lowerLimitCommissions()->create([
                            'lower_limit_id' => $lower_limit_ceramic?->id,
                            'category_id'    => $category?->id,
                            'target_payment' => $lower_limit_ceramic?->target_payment,
                            'value'          => $lower_limit_ceramic?->value,
                        ]);
                    }
                }

                $sum_income_tax = PaymentDetail::whereHas('invoice', function ($query) use ($invoice) {
                    $query->whereHas('user', function ($query) use ($invoice) {
                        $query->where('id', $invoice?->user?->id);
                    })->whereYear('date', (int)$invoice?->date->format('Y'))->whereMonth('date', (int)$invoice?->date->format('m'))->where('type', 'roof');
                })->when($category != null, function ($query) use ($category) {
                    $query->where('category_id', $category?->id);
                })->when($category == null, function ($query) use ($category) {
                    $query->whereNull('category_id');
                    // $query->where('version', 2);
                })->where('version', 2)->sum('income_tax');

                $get_lower_limit_commission = $get_commission?->lowerLimitCommissions()->when($category != null, function ($query) use ($category) {
                    $query->where('category_id', $category?->id);
                })->when($category == null, function ($query) use ($category) {
                    $query->whereNull('category_id');
                })->where('target_payment', '<=', (int)$sum_income_tax)->max('value');

                $get_lower_limit_commission = $get_lower_limit_commission ?? null;

                $get_commission?->update([
                    'total_sales'                 => $sum_income_tax,
                    'percentage_value_commission' => $get_lower_limit_commission,
                    'status'                      => $get_lower_limit_commission != null ? 'reached' : 'not-reach'
                ]);

                if ($get_commission?->percentage_value_commission != null && $category == null) {

                    $value_salesman = array(
                        70  => 0.4,
                        80  => 0.5,
                        90  => 0.6,
                        100 => 0.7,
                    );

                    $percentage_value_commission = $value_salesman[$get_commission?->percentage_value_commission] ?? 0;

                    foreach ($get_commission?->commissionDetails()->get() as $key => $commission_detail) {
                        $commission_detail->update([
                            'value_of_due_date' => $commission_detail?->total_income * ($percentage_value_commission/100)
                        ]);
                    }

                    if ($get_commission->commissionDetails()->whereNot('percentage_of_due_date', 0)->sum('value_of_due_date') > 0) {
                        $get_commission->update([
                            'value_commission' => $get_commission->commissionDetails()->whereNot('percentage_of_due_date', 0)->sum('value_of_due_date')
                        ]);
                    }

                }

                //fee intersif DR SONNE
                if ($category != null) {
                    $this->feeIntensif($sum_income_tax, $get_commission);
                }

            }
        } catch (Exception | Throwable $th) {
            $error = [
                'message' => $th->getMessage(),
                'file'    => $th->getFile(),
                'line'    => $th->getLine(),
            ];
            Log::error("Ada kesalahan saat proses payment detail atap v2", $error);
            throw new \Exception($th->getMessage());
        }
    }

    private function feeIntensif($sum_income_tax, $get_commission)
    {
        if ($sum_income_tax >= 25000000 && $sum_income_tax <= 50000000) {
            $get_commission->update([
                 'add_on_commission' => 200000
            ]);
        } elseif ($sum_income_tax >= 50000000 && $sum_income_tax <= 100000000) {
            $get_commission->update([
                 'add_on_commission' => 300000
            ]);
        } elseif ($sum_income_tax >= 100000000) {
            $get_commission->update([
                 'add_on_commission' => 400000
            ]);
        }
    }
}
