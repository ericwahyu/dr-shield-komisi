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

    private function createDueDateRule($invoice, $due_date)
    {
        $data_due_dates = [
            [
                'due_date' => 0,
                'value'    => 100,
            ],
            [
                'due_date' => 15,
                'value'    => 50,
            ],
            [
                'due_date' => 7,
                'value'    => 0,
            ],
        ];

        foreach ($data_due_dates as $key => $data_due_date) {
            if ($key == 0) {
                $invoice->dueDateRules()->create(
                    [
                        'type'     => 'roof',
                        'due_date' => $data_due_date['due_date'],
                        'value'    => $data_due_date['value'],
                    ]
                );
            } elseif ($key == 1) {
                $invoice->dueDateRules()->create(
                    [
                        'type'     => 'roof',
                        'due_date' => $due_date <= 30 ? 30 + (int)$data_due_date['due_date'] : (int)$due_date + (int)$data_due_date['due_date'],
                        'value'    => $data_due_date['value'],
                    ]
                );
            } elseif ($key > 1) {
                $get_due_date_rule = $invoice->dueDateRules()->orderBy('value', 'ASC')->first();
                $invoice->dueDateRules()->create(
                    [
                        'type'     => 'roof',
                        'due_date' => (int)$get_due_date_rule?->due_date + (int)$data_due_date['due_date'],
                        'value'    => $data_due_date['value'],
                    ]
                );
            }
        }
    }
}
