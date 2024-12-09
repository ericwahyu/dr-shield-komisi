<?php

namespace App\Imports\Invoice\RoofInvoice;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RoofInvoiceImport implements WithMultipleSheets
{
    /**
    * @param Collection $collection
    */
    public function sheets(): array
    {
        //
        return [
            'faktur'     => new RoofInvoiceExecutionImport(),
            'pembayaran' => new RoofInvoiceDetailExecutionImport(),
        ];
    }
}
