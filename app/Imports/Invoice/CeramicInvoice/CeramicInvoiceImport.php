<?php

namespace App\Imports\Invoice\CeramicInvoice;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CeramicInvoiceImport implements WithMultipleSheets
{
    /**
    * @param Collection $collection
    */
    public function sheets(): array
    {
        return [
            'faktur'     => new CeramicInvoiceExecutionImport(),
            'pembayaran' => new CeramicInvoiceDetailExecutionImport(),
        ];
    }
}
