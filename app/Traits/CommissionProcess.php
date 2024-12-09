<?php

namespace App\Traits;

use App\Models\Auth\User;
use App\Models\Commission\ActualTarget;
use App\Models\Commission\Commission;
use App\Models\Invoice\Invoice;
use App\Models\Invoice\InvoiceDetail;
use App\Models\Invoice\PaymentDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

trait CommissionProcess
{
    //
    use GetSystemSetting;

    public function ceramicCommission($invoice, $datas)
    {
        try {
            $get_commission = Commission::where('user_id', $datas['sales_id'])->where('month', (int)$invoice?->date?->format('m'))->where('year', (int)$invoice?->date?->format('Y'))->whereNull('category_id')->first();
            if (!$get_commission) {
                $commission = Commission::create([
                    'user_id'    => $datas['sales_id'],
                    'month'      => $invoice?->date?->format('m'),
                    'year'       => $invoice?->date?->format('Y'),
                    'income_tax' => (int)$datas['income_tax'],
                    'status'     => 'not-reach'
                ]);

                if (count($commission->lowerLimitCommissions) == 0) {
                    $lower_limit_ceramics = User::find($datas['sales_id'])->lowerLimits()->whereNull('category_id')->get();
                    foreach ($lower_limit_ceramics as $key => $lower_limit_ceramic) {
                        $commission->lowerLimitCommissions()->create([
                            'lower_limit_id' => $lower_limit_ceramic?->id,
                            'target_payment' => $lower_limit_ceramic?->target_payment,
                            'value'          => $lower_limit_ceramic?->value,
                        ]);
                    }
                }
            } else {
                $sum_income_tax = Invoice::whereHas('user', function ($query) use ($datas) {
                    $query->where('id', $datas['sales_id']);
                })->whereYear('date', (int)$invoice?->date->format('Y'))->whereMonth('date', (int)$invoice?->date->format('m'))->where('type', 'ceramic')->sum('income_tax');

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
                            'value_of_due_date' => $commission_detail?->total_income * ($get_commission?->percentage_value_commission/100)
                        ]);
                    }
                }
            }
        } catch (Exception | Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            Log::error("Ada kesalahan saat proses komisi keramik");
        }
    }

    public function ceramicCommissionDetail($get_invoice, $datas)
    {
        try {
            //code...
            $get_commission = Commission::where('user_id', $get_invoice?->user?->id)->where('year', (int)$get_invoice?->date?->format('Y'))->where('month', (int)$get_invoice?->date?->format('m'))->whereNull('category_id')->first();
            if ($get_commission) {
                $invoice_details = InvoiceDetail::whereHas('invoice', function ($query) use ($get_invoice) {
                    $query->whereYear('date', (int)$get_invoice?->date?->format('Y'))->whereMonth('date', (int)$get_invoice?->date?->format('m'))
                        ->where('user_id', $get_invoice?->user?->id);
                });

                foreach ($invoice_details->distinct()->pluck('percentage')->toArray() as $key => $percentage_invoice_details) {

                    foreach (($invoice_details->selectRaw('YEAR(date) as year, MONTH(date) as month')->groupBy('year', 'month')
                    ->distinct()
                    ->get()
                    ->map(function ($item) {
                        return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
                    })
                    ->toArray()) as $key => $year_month_invoice_detail) {

                        $total_income = InvoiceDetail::whereHas('invoice', function ($query) use ($get_invoice) {
                            $query->whereYear('date', (int)$get_invoice?->date?->format('Y'))->whereMonth('date', (int)$get_invoice?->date?->format('m'))
                                ->where('user_id', $get_invoice?->user?->id);
                        })->whereYear('date', (int)Carbon::parse($year_month_invoice_detail)->format('Y'))->whereMonth('date', (int)Carbon::parse($year_month_invoice_detail)->format('m'))->where('percentage', (int)$percentage_invoice_details)->sum('amount');

                        $get_commission->commissionDetails()->updateOrCreate(
                            [
                                'year'                   => (int)Carbon::parse($year_month_invoice_detail)->format('Y'),
                                'month'                  => (int)Carbon::parse($year_month_invoice_detail)->format('m'),
                                'percentage_of_due_date' => $percentage_invoice_details
                            ],
                            [
                                'total_income'      => round((int)$total_income/floatval($this->getSystemSetting()?->value_of_total_income)*((int)$percentage_invoice_details > 0 ? (int)$percentage_invoice_details/100 : 1), 2),
                                'value_of_due_date' => $get_commission?->percentage_value_commission != null ? round((int)$total_income/floatval($this->getSystemSetting()?->value_of_total_income)*((int)$percentage_invoice_details/100), 2) * ($get_commission?->percentage_value_commission/100) : null
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
                            'value_of_due_date' => $commission_detail?->total_income * ($get_commission?->percentage_value_commission/100)
                        ]);
                    }
                }
            }
        } catch (Exception | Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            Log::error("Ada kesalahan proses detail komisi keramik");
        }
    }

    public function roofCommission($invoice, $category, $datas)
    {
        //create commission
        try {
            $get_commission = Commission::where('user_id', $datas['sales_id'])->where('month', (int)$invoice?->date?->format('m'))->where('year', (int)$invoice?->date?->format('Y'))->where('category_id', $category?->id)->first();
            if (!$get_commission) {
                $commission = Commission::create([
                    'user_id'     => $datas['sales_id'],
                    'category_id' => $category?->id,
                    'month'       => $invoice?->date?->format('m'),
                    'year'        => $invoice?->date?->format('Y'),
                    'total_sales' => $invoice?->paymentDetails()->where('category_id', $category?->id)->sum('amount'),
                    'status'      => 'not-reach'
                ]);

                if (count($commission->lowerLimitCommissions) == 0) {
                    $lower_limit_ceramics = User::find($datas['sales_id'])->lowerLimits()->where('category_id', $category?->id)->get();
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
                $sum_income_tax = PaymentDetail::whereHas('invoice', function ($query) use ($invoice, $datas) {
                    $query->whereHas('user', function ($query) use ($datas) {
                        $query->where('id', $datas['sales_id']);
                    })->whereYear('date', (int)$invoice?->date->format('Y'))->whereMonth('date', (int)$invoice?->date->format('m'))->where('type', 'roof');
                })->where('category_id', $category?->id)->sum('income_tax');

                $get_lower_limit_commission = $get_commission?->lowerLimitCommissions()->where('category_id', $category?->id)->where('target_payment', '<=', (int)$sum_income_tax)->max('value');
                $get_lower_limit_commission = $get_lower_limit_commission ?? null;

                $get_commission?->update([
                    'total_sales'                 => $sum_income_tax,
                    'percentage_value_commission' => $get_lower_limit_commission,
                    'status'                      => $get_lower_limit_commission != null ? 'reached' : 'not-reach'
                ]);
            }
        } catch (Exception | Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            Log::error("Ada kesalahan saat proses komisi atap");
        }
    }

    public function roofCommissionDetail($get_invoice, $category)
    {
        try {
            $get_commission = Commission::where('user_id', $get_invoice?->user?->id)->where('year', (int)$get_invoice?->date?->format('Y'))->where('month', (int)$get_invoice?->date?->format('m'))->where('category_id', $category?->id)->first();
            if ($get_commission) {
                $invoice_details = InvoiceDetail::whereHas('invoice', function ($query) use ($category, $get_invoice) {
                    $query->whereYear('date', (int)$get_invoice?->date?->format('Y'))->whereMonth('date', (int)$get_invoice?->date?->format('m'))->where('user_id', $get_invoice?->user?->id)->where('category_id', $category?->id);
                });

                foreach ($invoice_details->distinct()->pluck('percentage')->toArray() as $key => $percentage_invoice_details) {

                    foreach (($invoice_details->selectRaw('YEAR(date) as year, MONTH(date) as month')->groupBy('year', 'month')
                    ->distinct()
                    ->get()
                    ->map(function ($item) {
                        return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
                    })
                    ->toArray()) as $key => $year_month_invoice_detail) {

                        $total_income = InvoiceDetail::whereHas('invoice', function ($query) use ($category, $get_invoice) {
                            $query->whereYear('date', (int)$get_invoice?->date?->format('Y'))->whereMonth('date', (int)$get_invoice?->date?->format('m'))->where('user_id', $get_invoice?->user?->id)->where('category_id', $category?->id);
                        })->whereYear('date', (int)Carbon::parse($year_month_invoice_detail)->format('Y'))->whereMonth('date', (int)Carbon::parse($year_month_invoice_detail)->format('m'))->where('percentage', (int)$percentage_invoice_details)->sum('amount');

                        try {
                            DB::transaction(function () use ($get_commission, $year_month_invoice_detail, $percentage_invoice_details, $total_income, $category) {
                                if (in_array($category?->slug, ['dr-shield'])) {
                                    $total_income = round((int)$total_income / floatval($this->getSystemSetting()?->value_of_total_income)*((int)$percentage_invoice_details > 0 ? (int)$percentage_invoice_details/100 : 1), 2);
                                 } else {
                                     $total_income = round((int)$total_income / floatval((int)$percentage_invoice_details > 0 ? (int)$percentage_invoice_details/100 : 1), 2);
                                 }
                                 $get_commission->commissionDetails()->updateOrCreate(
                                     [
                                         'year'                   => (int)Carbon::parse($year_month_invoice_detail)->format('Y'),
                                         'month'                  => (int)Carbon::parse($year_month_invoice_detail)->format('m'),
                                         'percentage_of_due_date' => $percentage_invoice_details
                                     ],
                                     [
                                         'total_income'      => $total_income,
                                         'value_of_due_date' => $get_commission?->percentage_value_commission != null ? $total_income * ($get_commission?->percentage_value_commission/100) : null
                                     ]
                                 );
                            });
                        } catch (Exception | Throwable $th) {
                            DB::rollBack();
                            Log::error($th->getMessage());
                            Log::error("Ada kesalahan saat create roof commission detail");
                        }
                    }
                }

                if ($get_commission?->status == 'reached' && $get_commission?->percentage_value_commission != null) {
                    $get_total_income  = $get_commission->commissionDetails()->whereNot('percentage_of_due_date', 0)->sum('total_income');
                    $get_actual_target = ActualTarget::where('category_id', $category?->id)->where('target', '<=', $get_total_income)->where('actual', $get_commission?->percentage_value_commission)->max('target');
                    $actual_target     = ActualTarget::where('category_id', $category?->id)->where('target', $get_actual_target)->where('actual', $get_commission?->percentage_value_commission)->first();
                    try {
                        DB::transaction(function () use ($get_commission, $actual_target) {
                            $get_commission?->update([
                                'value_commission' => $actual_target?->value_commission,
                            ]);
                        });
                    } catch (Exception | Throwable $th) {
                        DB::rollBack();
                        Log::error($th->getMessage());
                        Log::error("Ada kesalahan saat set roof value commission");
                    }
                }
            }
        } catch (Exception | Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            Log::error("Ada kesalahan saat proses komisi detail atap");
        }
    }
}
