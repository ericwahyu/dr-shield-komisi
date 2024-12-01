<?php

namespace App\Imports\Invoice\RoofInvoice;

use App\Models\Commission\ActualTarget;
use App\Models\Commission\Commission;
use App\Models\Invoice\Invoice;
use App\Models\Invoice\InvoiceDetail;
use App\Models\System\Category;
use App\Traits\GetSystemSetting;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Throwable;

class RoofInvoiceDetailExecutionImport implements ToCollection
{
    use GetSystemSetting;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collections)
    {
        //
        $categories = Category::where('type', 'roof')->get();
        try {
            foreach ($collections as $key => $collection) {
                if ($key == 0) {
                    continue;
                }

                $get_invoice = Invoice::where('invoice_number', $collection[0])->first();

                if (!$get_invoice) {
                    continue;
                }

                DB::transaction(function () use ($get_invoice, $collection, $categories) {
                    $get_invoice->invoiceDetails()->create(
                        [
                            'category_id' => Category::where('type', 'roof')->where('slug', $collection[1])->first()?->id,
                            'amount'      => $collection[2],
                            'date'        => Carbon::parse($collection[3])->toDateString(),
                            'percentage'  => $this->percentageInvoiceDetail($get_invoice, Carbon::parse($collection[3])->toDateString()),
                        ]
                    );

                    foreach ($categories as $key => $category) {
                        $this->createCommissionDetail($category, $get_invoice);
                    }
                    // $this->createCommissionDetail('dr-sonne', $get_invoice);
                });
            }
        } catch (Exception | Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            Log::error("Ada kesalahan saat import detail faktur atap");
        }
    }

    private function percentageInvoiceDetail($get_invoice, $invoice_detail_date)
    {
        $get_diffDay    = Carbon::parse($get_invoice?->date?->format('d M Y'))->diffInDays($invoice_detail_date);
        $desc_due_dates = $get_invoice->dueDateRules()->orderBy('due_date', 'DESC')->get();
        $percentage = null;

        if (Carbon::parse($invoice_detail_date)->toDateString() <= Carbon::parse($get_invoice?->date?->format('d M Y'))->toDateString()) {
            $percentage = 100;
        } else {
            foreach ($desc_due_dates as $key => $desc_due_date) {
                if ((int)$get_diffDay > (int)$desc_due_date?->due_date) {
                    $percentage = $desc_due_date?->value;
                    break;
                }
            }
        }

        return $percentage;
    }

    private function createCommissionDetail($category , $get_invoice)
    {
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
                               $total_income = round((int)$total_income / floatval($this->getSystemSetting()?->value_of_total_income)*((int)$percentage_invoice_details/100), 2);
                            } else {
                                $total_income = round((int)$total_income / floatval((int)$percentage_invoice_details/100), 2);
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
                $get_actual_target = ActualTarget::whereHas('category', function ($query) use ($get_commission, $category) {
                    $query->where('id', $category?->id)->where('type', $get_commission?->user?->userDetail?->sales_type);
                })->where('target', '<=', $get_total_income)->where('actual', $get_commission?->percentage_value_commission)->max('target');

                $actual_target     = ActualTarget::whereHas('category', function ($query) use ($get_commission, $category) {
                    $query->where('id', $category?->id)->where('type', $get_commission?->user?->userDetail?->sales_type);
                })->where('target', $get_actual_target)->where('actual', $get_commission?->percentage_value_commission)->first();
                try {
                    DB::transaction(function () use ($get_commission, $actual_target) {
                        $get_commission?->update([
                            'actual_target_id' => $actual_target?->id,
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
    }
}
