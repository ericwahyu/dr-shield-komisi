<?php

namespace App\Imports\Invoice\CeramicInvoice;

use App\Jobs\Import\CeramicInvoice\CeramicInvoice as Job_Ceramic_invoice;
use App\Jobs\Import\CeramicInvoice\CeramicInvoiceDispatcher;
use App\Models\Auth\User;
use App\Models\Commission\Commission;
use App\Models\Invoice\DueDateRuleCeramic;
use App\Models\Invoice\Invoice;
use App\Traits\CommissionProcess;
use App\Traits\GetSystemSetting;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Throwable;
use Illuminate\Support\Str;

class CeramicInvoiceExecutionImport implements ToCollection
{
    use GetSystemSetting;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collections)
    {
        //
        try {
            //code...
            // Job_Ceramic_invoice::dispatch($collections);
            CeramicInvoiceDispatcher::dispatch($collections);
        } catch (Exception | Throwable $th) {
            Log::error($th->getMessage());
            Log::error("Ada kesalahan saat import faktur keramik");
        }
    }
}
