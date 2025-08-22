<?php

namespace App\Traits\CommissionDetailProcess;

use App\Models\Commission\ActualTarget;
use App\Models\Commission\Commission;
use App\Models\Invoice\InvoiceDetail;
use App\Models\System\Category;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

trait RoofCommissionDetailProsses
{
    //
    public function _roofCommissionDetail($invoice, $datas)
    {
        try {
            if ($datas['version'] == 1) {
                $categories = Category::where('version', 1)->get();
                foreach ($categories as $key => $category) {
                    $this->_roofCommissionDetailV1($invoice, $category, $datas);
                }
            } elseif ($datas['version'] == 2) {
                $categories = [null, 'dr-sonne'];
                foreach ($categories as $key => $category) {
                    $this->_roofCommissionDetailV2($invoice, $category, $datas);
                }
            }

        } catch (Exception | Throwable $th) {
            $error = [
                'message' => $th->getMessage(),
                'file'    => $th->getFile(),
                'line'    => $th->getLine(),
            ];
            Log::error("Ada kesalahan proses detail komisi keramik", $error);
            throw new Exception($th->getMessage());
        }
    }

    private function _roofCommissionDetailV1($invoice, $category, $datas)
    {
        try {
            $get_commission = Commission::where('user_id', $invoice?->user?->id)->where('year', (int)$invoice?->date?->format('Y'))->where('month', (int)$invoice?->date?->format('m'))->where('category_id', $category?->id)->where('version', 1)->first();
            if ($get_commission) {
                $invoice_details = InvoiceDetail::whereHas('invoice', function ($query) use ($category, $invoice) {
                    $query->whereYear('date', (int)$invoice?->date?->format('Y'))->whereMonth('date', (int)$invoice?->date?->format('m'))->where('user_id', $invoice?->user?->id);
                })->where('category_id', $category?->id)->where('version', 1);

                foreach ($invoice_details->distinct()->pluck('percentage')->toArray() as $key => $percentage_invoice_detail) {

                    foreach (($invoice_details->selectRaw('EXTRACT(YEAR FROM date) AS year, EXTRACT(MONTH FROM date) AS month')
                    ->distinct()
                    ->get()
                    ->map(function ($item) {
                        return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
                    })
                    ->toArray()) as $key => $year_month_invoice_detail) {

                        $total_income = InvoiceDetail::whereHas('invoice', function ($query) use ($category, $invoice) {
                            $query->whereYear('date', (int)$invoice?->date?->format('Y'))->whereMonth('date', (int)$invoice?->date?->format('m'))->where('user_id', $invoice?->user?->id);
                        })->whereYear('date', (int)Carbon::parse($year_month_invoice_detail)->format('Y'))->whereMonth('date', (int)Carbon::parse($year_month_invoice_detail)->format('m'))->where('percentage', (int)$percentage_invoice_detail)->where('version', 1)->where('category_id', $category?->id)->sum('amount');

                        try {
                            DB::transaction(function () use ($get_commission, $year_month_invoice_detail, $percentage_invoice_detail, $total_income, $category) {
                                // if (in_array($category?->slug, ['dr-shield'])) {
                                //     $total_income = round((int)$total_income / floatval($this->getSystemSetting()?->value_of_total_income) * ((int)$percentage_invoice_detail > 0 ? (int)$percentage_invoice_detail/100 : 1), 2);
                                // } else {
                                //     $total_income = round((int)$total_income / floatval((int)$percentage_invoice_detail > 0 ? (int)$percentage_invoice_detail/100 : 1), 2);
                                // }

                                if ((int)$percentage_invoice_detail > 0) {
                                    $total_income = round((int)$total_income / floatval($this->getSystemSetting()?->value_of_total_income) * ((int)$percentage_invoice_detail > 0 ? (int)$percentage_invoice_detail/100 : 1), 2);
                                } else {
                                    $total_income = (int)$total_income;
                                }

                                // value commission by total income
                                $get_lower_limit_commission = $get_commission?->lowerLimitCommissions()->where('category_id', $category?->id)->where('target_payment', '<=', (int)$total_income)->max('value');
                                $get_lower_limit_commission = $get_lower_limit_commission ?? null;
                                $get_commission?->update([
                                    'percentage_value_commission' => $get_lower_limit_commission,
                                    'status'                      => $get_lower_limit_commission != null ? 'reached' : 'not-reach'
                                ]);

                                $get_commission->commissionDetails()->updateOrCreate(
                                     [
                                         'year'                   => (int)Carbon::parse($year_month_invoice_detail)->format('Y'),
                                         'month'                  => (int)Carbon::parse($year_month_invoice_detail)->format('m'),
                                         'percentage_of_due_date' => $percentage_invoice_detail
                                     ],
                                     [
                                         'total_income'      => (int)$total_income,
                                         'value_of_due_date' => $get_commission?->percentage_value_commission != null ? round($total_income * ($get_commission?->percentage_value_commission/100), 0) : null
                                     ]
                                 );
                            });
                        } catch (Exception | Throwable $th) {
                            DB::rollBack();
                            $error = [
                                'message' => $th->getMessage(),
                                'file'    => $th->getFile(),
                                'line'    => $th->getLine(),
                            ];
                            Log::error("Ada kesalahan saat create roof commission detail v1", $error);
                            throw new Exception($th->getMessage());
                        }
                    }
                }

                if ($get_commission?->status == 'reached' && $get_commission?->percentage_value_commission != null) {
                    $get_total_income  = $get_commission->user?->lowerLimits()->where('category_id', $category?->id)->max('target_payment');
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
                        $error = [
                            'message' => $th->getMessage(),
                            'file'    => $th->getFile(),
                            'line'    => $th->getLine(),
                        ];
                        Log::error("Ada kesalahan saat set roof value commission v1", $error);
                        throw new Exception($th->getMessage());
                    }
                }
            }
        } catch (Exception | Throwable $th) {
            DB::rollBack();
            $error = [
                'message' => $th->getMessage(),
                'file'    => $th->getFile(),
                'line'    => $th->getLine(),
            ];
            Log::error("Ada kesalahan saat proses detail komisi atap V1", $error);
            throw new Exception($th->getMessage());
        }
    }
    private function _roofCommissionDetailV2($invoice, $category, $datas)
    {

        try {
            $category = $category = $category != null ? Category::where('slug', $category)->where('version', 2)->first() : $category;

            $get_commission = Commission::where('user_id', $invoice?->user?->id)->where('year', (int)Carbon::parse($datas['invoice_detail_date'])?->format('Y'))->where('month', (int)Carbon::parse($datas['invoice_detail_date'])?->format('m'))
                ->when($category != null, function ($query) use ($category) {
                    $query->where('category_id', $category?->id);
                })->when($category == null, function ($query) use ($category) {
                    $query->whereNull('category_id');
                })->where('version', 2)->first();

            if ($get_commission && $category == null) {

                $percentage_invoice_details = $this->__invoiceDetailQueryV2($invoice, $category, $datas)->distinct()->orderBy('percentage', "DESC")->pluck('percentage')->toArray();

                $year_month_invoice_details = $this->__invoiceDetailQueryV2($invoice, $category, $datas)->selectRaw('EXTRACT(YEAR FROM date) AS year, EXTRACT(MONTH FROM date) AS month')
                ->distinct()
                ->get()->map(function ($item) {
                    return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
                })
                ->toArray();

                foreach ($percentage_invoice_details as $key => $percentage_invoice_detail) {

                    foreach ($year_month_invoice_details as $key => $year_month_invoice_detail) {

                        $total_income = InvoiceDetail::whereHas('invoice', function ($query) use ($category, $invoice, $datas) {
                            $query->where('user_id', $invoice?->user?->id);
                        })->whereYear('date', (int)Carbon::parse($year_month_invoice_detail)->format('Y'))->whereMonth('date', (int)Carbon::parse($year_month_invoice_detail)->format('m'))->where('percentage', (int)$percentage_invoice_detail)
                        ->when($category != null, function ($query) use ($category) {
                            $query->where('category_id', $category?->id);
                        })->when($category == null, function ($query) use ($category) {
                            $query->whereNull('category_id');
                        })->where('version', 2)->sum('amount');

                        if (in_array($category?->slug, ['dr-sonne']) || $category != null) {
                            $total_income = round((int)$total_income / floatval((int)$percentage_invoice_detail > 0 ? (int)$percentage_invoice_detail/100 : 1), 2);
                        } else {
                            //  $total_income = round((int)$total_income / floatval($this->getSystemSetting()?->value_of_total_income) * ((int)$percentage_invoice_detail > 0 ? (int)$percentage_invoice_detail/100 : 1), 2);
                            $total_income = round((int)$total_income * ((int)$percentage_invoice_detail > 0 ? (int)$percentage_invoice_detail/100 : 1), 2);
                         }

                        $get_commission->commissionDetails()->updateOrCreate(
                            [
                                'year'                   => (int)Carbon::parse($year_month_invoice_detail)->format('Y'),
                                'month'                  => (int)Carbon::parse($year_month_invoice_detail)->format('m'),
                                'percentage_of_due_date' => $percentage_invoice_detail
                            ],
                            [
                                'total_income'      => (int)$total_income,
                                'value_of_due_date' => $percentage_invoice_detail > 0 ? round($total_income * ($get_commission?->percentage_value_commission/100), 0) : null
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
                            'value_of_due_date' => $commission_detail?->percentage_of_due_date > 0 ? (int)($commission_detail?->total_income * ($percentage_value_commission/100)) : null
                        ]);
                    }
                }

                if ($get_commission->commissionDetails()->whereNot('percentage_of_due_date', 0)->sum('value_of_due_date') > 0) {
                    $get_commission->update([
                        'value_commission' => $get_commission->commissionDetails()->whereNot('percentage_of_due_date', 0)->sum('value_of_due_date')
                    ]);
                }
            } elseif ($get_commission  && $category != null) {
                # code...
                $total_income = InvoiceDetail::whereHas('invoice', function ($query) use ($category, $invoice, $datas) {
                    $query->where('user_id', $invoice?->user?->id);
                })->whereYear('date', (int)Carbon::parse($datas['invoice_detail_date'])?->format('Y'))->whereMonth('date', (int)Carbon::parse($datas['invoice_detail_date'])?->format('m'))
                ->when($category != null, function ($query) use ($category) {
                    $query->where('category_id', $category?->id);
                })->when($category == null, function ($query) use ($category) {
                    $query->whereNull('category_id');
                })->where('version', 2)->sum('amount');

                $get_lower_limit_commission = $get_commission?->lowerLimitCommissions()->when($category != null, function ($query) use ($category) {
                    $query->where('category_id', $category?->id);
                })->when($category == null, function ($query) use ($category) {
                    $query->whereNull('category_id');
                })->where('target_payment', '<=', (int)$total_income)->max('value');

                $get_lower_limit_commission = $get_lower_limit_commission ?? null;

                $get_commission?->update([
                    'percentage_value_commission' => $get_lower_limit_commission,
                    // 'status'                      => $get_lower_limit_commission != null ? 'reached' : 'not-reach',
                    'value_commission'            => $get_commission?->status == 'reached' ? $this->__getCommissionDrSonneV2((int)$total_income) : null
                ]);
            }
        } catch (Exception | Throwable $th) {
            $error = [
                'message' => $th->getMessage(),
                'file'    => $th->getFile(),
                'line'    => $th->getLine(),
            ];
            Log::error("Ada kesalahan saat proses detail komisi atap V2", $error);
            throw new Exception($th->getMessage());
        }
    }

    private function __invoiceDetailQueryV2($invoice, $category, $datas)
    {
        $invoice_details = InvoiceDetail::whereHas('invoice', function ($query) use ($category, $invoice, $datas) {
            $query->where('user_id', $invoice?->user?->id);
        })->whereYear('date', (int)Carbon::parse($datas['invoice_detail_date'])?->format('Y'))->whereMonth('date', (int)Carbon::parse($datas['invoice_detail_date'])?->format('m'))
        ->when($category != null, function ($query) use ($category) {
            $query->where('category_id', $category?->id);
        })->when($category == null, function ($query) use ($category) {
            $query->whereNull('category_id');
        })->where('version', 2);

        return $invoice_details;
    }

    private function __getCommissionDrSonneV2($value) {
        $value_commissions = array(
            100000000 => 400000,
            50000000  => 300000,
            25000000  => 200000,
        );

        // Mengambil kunci terendah
        $lowest_threshold = min(array_keys($value_commissions));

        if ($value < $lowest_threshold) {
            return null;
        }

        ksort($value_commissions);

       // Inisialisasi variabel untuk menyimpan komisi
        $commission = null;

        foreach ($value_commissions as $threshold => $commission_value) {
            if ($value < $threshold) {
                // Jika nilai lebih kecil dari threshold, simpan komisi sebelumnya
                // dan keluar dari loop
                break;
            }
            // Jika nilai lebih besar atau sama dengan threshold, simpan komisi
            $commission = $commission_value;
        }

        // Jika tidak ada komisi yang ditemukan, ambil komisi terakhir
        if ($commission === null) {
            $commission = end($value_commissions);
        }

        return $commission; // Output komisi
    }
}
