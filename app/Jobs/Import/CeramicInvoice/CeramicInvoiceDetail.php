<?php

namespace App\Jobs\Import\CeramicInvoice;

use App\Models\Invoice\Invoice;
use App\Traits\CommissionProcess;
use App\Traits\GetSystemSetting;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CeramicInvoiceDetail implements ShouldQueue
{
    use Queueable;
    use GetSystemSetting, CommissionProcess;

    protected $collections;

    /**
     * Create a new job instance.
     */
    public function __construct($collections)
    {
        //
        $this->collections = $collections;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        try {
            foreach ($this->collections as $key => $collection) {
                if ($key == 0) {
                    continue;
                }

                $get_invoice = Invoice::where('invoice_number', $collection[0])->first();

                $check_year = Carbon::parse($collection[2])->format('Y');

                if (!$get_invoice || (int)$check_year < 2010) {
                    continue;
                }

                DB::transaction(function () use ($get_invoice, $collection) {
                    $get_invoice->invoiceDetails()->create(
                        [
                            'amount'     => $collection[1],
                            'date'       => Carbon::parse($collection[2])->toDateString(),
                            'percentage' => $this->percentageInvoiceDetail($get_invoice, Carbon::parse($collection[2])->toDateString()),
                        ]
                    );

                    $datas = array();
                    $this->ceramicCommissionDetail($get_invoice, $datas);
                });
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            Log::error("Ada kesalahan saat import detail faktur keramik");
        }
    }

    private function percentageInvoiceDetail($get_invoice, $invoice_detail_date)
    {
        $get_diffDay    = Carbon::parse($get_invoice?->date?->format('d M Y'))->diffInDays($invoice_detail_date);
        $desc_due_dates = $get_invoice->dueDateRules()->orderBy('due_date', 'DESC')->get();
        $percentage     = 0;

        if (Carbon::parse($invoice_detail_date)->toDateString() <= Carbon::parse($get_invoice?->date?->format('d M Y'))->toDateString()) {
            $percentage = 100;
        } else {
            foreach ($desc_due_dates as $key => $desc_due_date) {
                if ((int)$get_diffDay > (int)$desc_due_date?->due_date) {
                    $percentage = $desc_due_date?->value;
                    break;
                }
            }
        }

        // if ($percentage == null) {
        //     $percentage = 0;
        // }

        return $percentage;
    }
}
