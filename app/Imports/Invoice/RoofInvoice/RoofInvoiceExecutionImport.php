<?php

namespace App\Imports\Invoice\RoofInvoice;

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
        $categories = Category::where('type', 'roof')->get();
        try {
            foreach ($collections as $key => $collection) {
                if ($key == 0) {
                    continue;
                }

                foreach ($categories as $key => $category) {
                    $check_lower_limit = User::where('name', 'LIKE', "%". $collection[7] ."%")->whereHas('userDetail', function ($query) use ($collection) {
                        $query->where('depo', 'LIKE', "%". $collection[6] ."%");
                    })->first()?->lowerLimits()->where('category_id', $category?->id)->first();

                    if (!$check_lower_limit) {
                        continue;
                    }
                }

                $get_user = User::where('name', 'LIKE', "%". $collection[7] ."%")->whereHas('userDetail', function ($query) use ($collection) {
                    $query->where('depo', 'LIKE', "%". $collection[6] ."%");
                })->first();

                $unique_invoice = Invoice::where('invoice_number', $collection[1])->first();

                $check_year = Carbon::parse($collection[0])->format('Y');

                if (!$get_user || $unique_invoice || (int)$check_year < 2010) {
                    continue;
                }

                DB::transaction(function () use ($collection, $get_user, $categories) {

                    $invoice = Invoice::create(
                        [
                            'user_id'        => $get_user?->id,
                            'type'           => 'roof',
                            'date'           => $collection[0],
                            'invoice_number' => $collection[1],
                            'customer'       => $collection[2],
                            'id_customer'    => $collection[8],
                            'income_tax'     => (int)$collection[10] + (int)$collection[13],
                            'value_tax'      => (int)$collection[11] + (int)$collection[14],
                            'amount'         => (int)$collection[12] + (int)$collection[15],
                            'due_date'       => $collection[9],
                        ]
                    );

                    $this->createDueDateRule($invoice, $collection[9]);
                    foreach ($categories as $key => $category) {
                        $index = 10;
                        if ($category?->slug == 'dr-shield') {
                            $index = 10;
                        } elseif ($category?->slug == 'dr-sonne') {
                            $index = 13;
                        } else {
                            $index = 100;
                        }
                        $invoice->paymentDetails()->updateOrCreate(
                            [
                                'category_id' => $category?->id
                            ],
                            [
                                'category_id' => $category?->id,
                                'income_tax'  => (int)number_format($collection[$index], 0, ',', ''),
                                'value_tax'   => (int)number_format($collection[$index + 1], 0, ',', ''),
                                'amount'      => (int)number_format($collection[$index + 2], 0, ',', ''),
                            ]
                        );

                        $datas = array(
                            'sales_id'   => $invoice?->user?->id,
                        );
                        $this->roofCommission($invoice, $category, $datas);
                    }
                });
            }
        } catch (Exception | Throwable $th) {
            DB::rollBack();
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
                        'number'   => $key,
                        'due_date' => $data_due_date['due_date'],
                        'value'    => $data_due_date['value'],
                    ]
                );
            } elseif ($key == 1) {
                $invoice->dueDateRules()->create(
                    [
                        'type'     => 'roof',
                        'number'   => $key,
                        'due_date' => $due_date <= 30 ? 30 + (int)$data_due_date['due_date'] : (int)$due_date + (int)$data_due_date['due_date'],
                        'value'    => $data_due_date['value'],
                    ]
                );
            } elseif ($key > 1) {
                $get_due_date_rule = $invoice->dueDateRules()->orderBy('number', 'DESC')->first();
                $invoice->dueDateRules()->create(
                    [
                        'type'     => 'roof',
                        'number'   => $key,
                        'due_date' => (int)$get_due_date_rule?->due_date + (int)$data_due_date['due_date'],
                        'value'    => $data_due_date['value'],
                    ]
                );
            }
        }
    }
}
