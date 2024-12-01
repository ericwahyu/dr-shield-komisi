<?php

namespace App\Imports\Invoice\CeramicInvoice;

use App\Models\Auth\User;
use App\Models\Commission\Commission;
use App\Models\Invoice\DueDateRuleCeramic;
use App\Models\Invoice\Invoice;
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
    use GetSystemSetting;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collections)
    {
        //
        try {

            foreach ($collections as $key => $collection) {
                if ($key == 0) {
                    continue;
                }
                $check_lower_limit = User::where('name', 'LIKE', "%". $collection[7] ."%")->whereHas('userDetail', function ($query) use ($collection) {
                    $query->where('depo', 'LIKE', "%". $collection[6] ."%");
                })->first()?->lowerLimits()->whereNull('category_id')->first();

                $get_user = User::where('name', 'LIKE', "%". $collection[7] ."%")->whereHas('userDetail', function ($query) use ($collection) {
                    $query->where('depo', 'LIKE', "%". $collection[6] ."%");
                })->first();

                if (!$check_lower_limit || !$get_user) {
                    continue;
                }

                DB::transaction(function () use ($get_user, $collection) {
                    // $avaiable_invoice = Invoice::where('invoice_number', $collection[1])->first();
                    $invoice = Invoice::create(
                        // [
                        //     'id' => $avaiable_invoice?->id
                        // ],
                        [
                            'user_id'        => $get_user?->id,
                            'type'           => 'ceramic',
                            'date'           => $collection[0],
                            'invoice_number' => $collection[1],
                            'customer'       => $collection[2],
                            'id_customer'    => $collection[8],
                            'income_tax'     => $collection[3],
                            'value_tax'      => $collection[4],
                            'amount'         => $collection[5],
                            'due_date'       => $collection[9],
                        ]
                    );

                    $due_date_rule_ceramics = DueDateRuleCeramic::where('type', 'ceramic')->orderBy('due_date', 'ASC')->get();
                    foreach ($due_date_rule_ceramics as $key => $due_date_rule_ceramic) {
                        $invoice->dueDateRules()->create(
                            [
                                'type'     => 'ceramic',
                                'due_date' => $due_date_rule_ceramic?->due_date,
                                'value'    => $due_date_rule_ceramic?->value,
                            ]
                        );
                    }

                    //create commission
                    $get_commission = Commission::where('user_id', $get_user?->id)->where('month', (int)$invoice?->date?->format('m'))->where('year', (int)$invoice?->date?->format('Y'))->whereNull('category_id')->first();
                    if (!$get_commission) {
                        $commission = Commission::create([
                            'user_id'    => $get_user?->id,
                            'month'      => $invoice?->date?->format('m'),
                            'year'       => $invoice?->date?->format('Y'),
                            'income_tax' => intval(Str::replace('.','',$collection[3])),
                            'status'     => 'not-reach'
                        ]);

                        if (count($commission->lowerLimitCommissions) == 0) {
                            $lower_limit_ceramics = User::find($get_user?->id)->lowerLimits()->whereNull('category_id')->get();
                            foreach ($lower_limit_ceramics as $key => $lower_limit_ceramic) {
                                $commission->lowerLimitCommissions()->create([
                                    'lower_limit_id' => $lower_limit_ceramic?->id,
                                    'target_payment' => $lower_limit_ceramic?->target_payment,
                                    'value'          => $lower_limit_ceramic?->value,
                                ]);
                            }
                        }
                    } else {
                        $sum_income_tax = Invoice::whereHas('user', function ($query) use ($get_user){
                            $query->where('id', $get_user?->id);
                        })->whereYear('date', (int)$invoice?->date->format('Y'))->whereMonth('date', (int)$invoice?->date->format('m'))->where('type', 'ceramic')->sum('income_tax');

                        $get_lower_limit_commission = $get_commission?->lowerLimitCommissions()->whereNull('category_id')->where('target_payment', '<=', (int)$sum_income_tax)->max('value');
                        $get_lower_limit_commission = $get_lower_limit_commission != null && $get_lower_limit_commission >= 0.3 ? $get_lower_limit_commission + $this->getSystemSetting()?->value_incentive : $get_lower_limit_commission;

                        $get_commission?->update([
                            'total_sales'                 => $sum_income_tax,
                            'percentage_value_commission' => $get_lower_limit_commission,
                            'status'                      => $get_lower_limit_commission != null ? 'reached' : 'not-reach'
                        ]);

                        if ($get_commission?->percentage_value_commission != null) {
                            foreach ($get_commission?->commissionDetails()->get() as $key => $commission_detail) {
                                $commission_detail->update([
                                    'value_of_due_date' => $commission_detail?->total_income * ($get_commission?->percentage_value_commission/100)
                                ]);
                            }
                        }
                    }
                });
            }

        } catch (Exception | Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            Log::error("Ada kesalahan saat import faktur keramik");
        }
    }
}
