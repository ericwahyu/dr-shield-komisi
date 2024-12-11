<?php

namespace App\Imports\Invoice\CeramicInvoice;

use App\Jobs\Import\CeramicInvoice\CeramicInvoice as Job_Ceramic_invoice;
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
    use GetSystemSetting, CommissionProcess;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collections)
    {
        //
        try {
            //code...
            Job_Ceramic_invoice::dispatch($collections);
        } catch (Exception | Throwable $th) {
            Log::error($th->getMessage());
            Log::error("Ada kesalahan saat import faktur keramik");
        }
        // try {

        //     foreach ($collections as $key => $collection) {
        //         if ($key == 0) {
        //             continue;
        //         }

        //         $check_lower_limit = User::where('name', 'LIKE', "%". $collection[7] ."%")->whereHas('userDetail', function ($query) use ($collection) {
        //             $query->where('depo', 'LIKE', "%". $collection[6] ."%");
        //         })->first()?->lowerLimits()->whereNull('category_id')->first();

        //         $get_user = User::where('name', 'LIKE', "%". $collection[7] ."%")->whereHas('userDetail', function ($query) use ($collection) {
        //             $query->where('depo', 'LIKE', "%". $collection[6] ."%");
        //         })->first();

        //         $unique_invoice = Invoice::where('invoice_number', $collection[1])->first();

        //         $check_year = Carbon::parse($collection[0])->format('Y');

        //         if (!$check_lower_limit || !$get_user || $unique_invoice || (int)$check_year < 2010) {
        //             continue;
        //         }

        //         DB::transaction(function () use ($get_user, $collection) {
        //             $invoice = Invoice::create(
        //                 [
        //                     'user_id'        => $get_user?->id,
        //                     'type'           => 'ceramic',
        //                     'date'           => $collection[0],
        //                     'invoice_number' => $collection[1],
        //                     'customer'       => $collection[2],
        //                     'id_customer'    => $collection[8],
        //                     'income_tax'     => $collection[3],
        //                     'value_tax'      => $collection[4],
        //                     'amount'         => $collection[5],
        //                     'due_date'       => $collection[9],
        //                 ]
        //             );

        //             $invoice->paymentDetails()->updateOrCreate(
        //                 [
        //                    'category_id' => null,
        //                    'income_tax'     => $collection[3],
        //                    'value_tax'      => $collection[4],
        //                    'amount'         => $collection[5],
        //                 ]
        //             );

        //             $due_date_rule_ceramics = DueDateRuleCeramic::where('type', 'ceramic')->orderBy('due_date', 'ASC')->get();
        //             foreach ($due_date_rule_ceramics as $key => $due_date_rule_ceramic) {
        //                 $invoice->dueDateRules()->create(
        //                     [
        //                         'type'     => 'ceramic',
        //                         'due_date' => $due_date_rule_ceramic?->due_date,
        //                         'value'    => $due_date_rule_ceramic?->value,
        //                     ]
        //                 );
        //             }

        //             //create commission
        //             $datas = array(
        //                 'sales_id'   => $invoice?->user?->id,
        //                 'income_tax' => $collection[3],
        //             );
        //             $this->ceramicCommission($invoice, $datas);
        //         });
        //     }

        // } catch (Exception | Throwable $th) {
        //     DB::rollBack();
        //     Log::error($th->getMessage());
        //     Log::error("Ada kesalahan saat import faktur keramik");
        // }
    }
}
