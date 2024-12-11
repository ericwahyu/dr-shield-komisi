<?php

namespace App\Imports\Invoice\CeramicInvoice;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Throwable;

class CeramicInvoiceImport implements WithMultipleSheets
{
    /**
    * @param Collection $collection
    */
    public function sheets(): array
    {
        try {
            return [
                'faktur'     => new CeramicInvoiceExecutionImport(),
                'pembayaran' => new CeramicInvoiceDetailExecutionImport(),
            ];
        } catch (Exception | Throwable $th) {
            Log::error($th->getMessage());
            Log::error('Ada kesalahan saat import data faktur keramik');
        }
    }
}
