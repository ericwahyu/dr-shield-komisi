<?php

namespace App\Imports\Invoice\RoofInvoice;

use App\Models\Commission\ActualTarget;
use App\Models\Commission\Commission;
use App\Models\Invoice\Invoice;
use App\Models\Invoice\InvoiceDetail;
use App\Models\System\Category;
use App\Traits\CommissionProcess;
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
    use GetSystemSetting, CommissionProcess;
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

                $check_year = Carbon::parse($collection[2])->format('Y');

                if (!$get_invoice || (int)$check_year < 2010) {
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

                    // dd($get_invoice->invoiceDetails()->first());

                    foreach ($categories as $key => $category) {
                        $this->roofCommissionDetail($get_invoice, $category);
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
}
