<?php

namespace App\Imports\Invoice\RoofInvoice;

use App\Jobs\Import\RoofInvoice\RoofInvoiceDetail as Job_Roof_Invoice_Detail;
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
        try {
            Job_Roof_Invoice_Detail::dispatch($collections);
        } catch (Exception | Throwable $th) {
            Log::error($th->getMessage());
            Log::error("Ada kesalahan saat import detail faktur atap");
        }
    }

    private function percentageInvoiceDetail($get_invoice, $invoice_detail_date)
    {
        $get_diffDay    = Carbon::parse($get_invoice?->date?->format('d M Y'))->diffInDays($invoice_detail_date);
        $desc_due_dates = $get_invoice->dueDateRules()->orderBy('due_date', 'DESC')->get();
        $percentage     = 0;

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

        // if ($percentage == null) {
        //     $percentage = 0;
        // }

        return $percentage;
    }
}
