<?php

namespace App\Imports\Invoice\RoofInvoice;

use App\Jobs\Import\RoofInvoice\RoofInvoice as Job_Roof_Invoice;
use App\Models\Auth\User;
use App\Models\Commission\Commission;
use App\Models\Invoice\Invoice;
use App\Models\Invoice\PaymentDetail;
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

class RoofInvoiceExecutionImport implements ToCollection
{
    use GetSystemSetting, CommissionProcess;
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collections)
    {
        //
        try {
            //code...
            Job_Roof_Invoice::dispatch($collections);
        } catch (Exception | Throwable $th) {
            Log::error($th->getMessage());
            Log::error("Ada kesalahan saat import faktur atap");
        }
    }
}
