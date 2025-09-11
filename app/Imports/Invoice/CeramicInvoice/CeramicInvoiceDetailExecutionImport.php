<?php

namespace App\Imports\Invoice\CeramicInvoice;

use App\Jobs\Import\CeramicInvoice\CeramicInvoiceDetail as Job_Ceramic_Invoice_Detail;
use App\Jobs\Import\CeramicInvoice\CeramicInvoiceDetailDispatcher;
use App\Models\Commission\Commission;
use App\Models\Invoice\Invoice;
use App\Models\Invoice\InvoiceDetail;
use App\Traits\CommissionProcess;
use App\Traits\GetSystemSetting;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class CeramicInvoiceDetailExecutionImport implements ToCollection
{
    use GetSystemSetting;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collections)
    {
        //
        try {

            // Job_Ceramic_Invoice_Detail::dispatch($collections);
            CeramicInvoiceDetailDispatcher::dispatch($collections);

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            Log::error("Ada kesalahan saat import detail faktur keramik");
        }
    }
}
