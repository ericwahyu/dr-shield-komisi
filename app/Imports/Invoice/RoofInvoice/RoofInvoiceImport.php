<?php

namespace App\Imports\Invoice\RoofInvoice;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Throwable;

class RoofInvoiceImport implements WithMultipleSheets
{
    /**
     * @param Collection $collection
     */
    public function sheets(): array
    {
        Log::info('Memulai proses import sheets');

        try {
            return [
                'faktur'     => new RoofInvoiceExecutionImport(),
                'pembayaran' => new RoofInvoiceDetailExecutionImport(),
            ];
        } catch (Exception | Throwable $th) {
            Log::error('Error di sheets(): ' . $th->getMessage());
            return [];
        }
    }
}
