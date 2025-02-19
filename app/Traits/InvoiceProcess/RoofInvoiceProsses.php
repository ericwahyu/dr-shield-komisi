<?php

namespace App\Traits\InvoiceProcess;

use App\Models\Invoice\DueDateRuleRoof;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

trait RoofInvoiceProsses
{
    //
    public function _roofInvoice($invoice, $datas)
    {
        try {
            if ($datas['version'] == 1) {
                $this->_roofInvoiceV1($invoice, $datas);
            } elseif ($datas['version'] == 2) {
                $this->_roofInvoiceV2($invoice, $datas);
            }

            foreach ($invoice?->invoiceDetails as $key => $invoice_detail) {
                $percentage     = null;
                $get_diffDay    = Carbon::parse($invoice?->date)->diffInDays($invoice_detail?->date);
                $desc_due_dates = $invoice->dueDateRules()->where('version', $datas['version'])->orderBy('due_date', 'DESC')->get();

                if (Carbon::parse($invoice_detail?->date)->toDateString() <= Carbon::parse($invoice?->date)->toDateString()) {
                    $percentage = 100;
                } else {
                    foreach ($desc_due_dates as $key => $desc_due_date) {
                        if ((int)$get_diffDay >= (int)$desc_due_date?->due_date) {
                            $percentage = $desc_due_date?->value;
                            break;
                        }
                    }
                }

                $invoice->invoiceDetails()->where('id', $invoice_detail?->id)->first()?->update([
                    'percentage' => $percentage
                ]);
            }

        } catch (Exception | Throwable $th) {
            Log::error("Ada kesalahan saat proses invoice atap");
            throw new Exception($th->getMessage());
        }
    }

    private function _roofInvoiceV1($invoice, $datas)
    {
        try {
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

            $invoice->dueDateRules()->where('version', 1)->delete();
            foreach ($data_due_dates as $key => $data_due_date) {
                if ($key == 0) {
                    $invoice->dueDateRules()->create(
                        [
                            'version'  => 1,
                            'due_date' => $data_due_date['due_date'],
                            'value'    => $data_due_date['value'],
                        ]
                    );
                } elseif ($key == 1) {
                    $invoice->dueDateRules()->create(
                        [
                            'version'  => 1,
                            'due_date' => $datas['due_date'] <= 30 ? 30 + (int)$data_due_date['due_date'] : (int)$datas['due_date'] + (int)$data_due_date['due_date'],
                            'value'    => $data_due_date['value'],
                        ]
                    );
                } elseif ($key > 1) {
                    $get_due_date_rule = $invoice->dueDateRules()->where('version', 1)->orderBy('value', 'ASC')->first();
                    $invoice->dueDateRules()->create(
                        [
                            'version'  => 1,
                            'due_date' => (int)$get_due_date_rule?->due_date + (int)$data_due_date['due_date'],
                            'value'    => $data_due_date['value'],
                        ]
                    );
                }
            }
        } catch (Exception | Throwable $th) {
            Log::error("Ada kesalahan saat proses invoice atap due_date_rules v1");
            throw new Exception($th->getMessage());
        }
    }

    private function _roofInvoiceV2($invoice, $datas)
    {
        try {
            $due_date_roof_rules = DueDateRuleRoof::where('type', 'roof')->where('version', 2)->orderBy('due_date', 'ASC')->get();

            $invoice->dueDateRules()->where('version', 2)->delete();
            foreach ($due_date_roof_rules as $key => $due_date_roof_rule) {
                if ($key == 0) {
                    $due_date = (int)$due_date_roof_rule?->due_date;
                } else {
                    $due_date = (int)$due_date_roof_rule?->due_date + (int)$datas['due_date'];
                }

                $invoice->dueDateRules()->where('version', 2)->updateOrCreate(
                    [
                        'version'  => 2,
                        'due_date' => $due_date,
                    ],
                    [
                        'version'  => 2,
                        'due_date' => $due_date,
                        'value'    => $due_date_roof_rule?->value,
                    ]
                );
            }
        } catch (Exception | Throwable $th) {
            Log::error("Ada kesalahan saat proses invoice atap due_date_rules v2");
            throw new Exception($th->getMessage());
        }
    }
}
