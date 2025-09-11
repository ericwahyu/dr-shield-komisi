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
        Log::info('Memulai proses import sheets');
        try {
            return [
                'faktur'     => new CeramicInvoiceExecutionImport(),
                'pembayaran' => new CeramicInvoiceDetailExecutionImport(),
            ];
        } catch (Exception | Throwable $th) {
            Log::error('Error di sheets Keramik(): ' . $th->getMessage());
            return [];
        }
    }
}
