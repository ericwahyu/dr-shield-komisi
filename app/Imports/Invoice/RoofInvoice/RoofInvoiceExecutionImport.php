<?php

namespace App\Imports\Invoice\RoofInvoice;

use App\Jobs\Import\RoofInvoice\RoofInvoice as Job_Roof_Invoice;
use App\Jobs\Import\RoofInvoice\RoofInvoiceDispatcher;
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
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Throwable;

class RoofInvoiceExecutionImport implements ToCollection, WithChunkReading, ShouldQueue
{
    use GetSystemSetting, CommissionProcess;
    /**
     * Set a reasonable chunk size to limit memory usage per chunk.
     */
    public function chunkSize(): int
    {
        return 250; // adjust if needed (e.g., 100, 250, 500)
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collections)
    {
        //
        try {
            //code...
            // Job_Roof_Invoice::dispatch($collections);
            RoofInvoiceDispatcher::dispatch($collections);
        } catch (Exception | Throwable $th) {
            Log::error($th->getMessage());
            Log::error("Ada kesalahan saat import faktur atap");
        }
    }
}
