<?php

namespace App\Jobs\Import\RoofInvoice;

use App\Models\Invoice\Invoice;
use App\Models\System\Category;
use App\Traits\CommissionDetailProcess\RoofCommissionDetailProsses;
use App\Traits\CommissionProcess;
use App\Traits\GetSystemSetting;
use App\Traits\InvoiceDetailProcess\RoofInvoiceDetailProsses;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Throwable;

class RoofInvoiceDetail implements ShouldQueue
{
    use Queueable, LivewireAlert;
    use GetSystemSetting, RoofInvoiceDetailProsses, RoofCommissionDetailProsses;

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

                $check_year = Carbon::parse($collection[3])->format('Y');

                $category          = Category::where('slug', $collection[1] ?? 'dr-shield')->where('version', 1)->first();
                $invoice_detail_v1 = $get_invoice?->invoiceDetails()->where('version', 1)->where('category_id', $category?->id)->where('amount', (int)$collection[2])->where('date', Carbon::parse($collection[3])->toDateString())->first();

                $category          = Category::where('slug', $collection[1] ?? 'dr-shield')->where('version', 2)->first();
                $invoice_detail_v2 = $get_invoice?->invoiceDetails()->where('version', 2)->where('category_id', $category?->id)->where('amount', (int)$collection[2])->where('date', Carbon::parse($collection[3])->toDateString())->first();

                if (!$get_invoice || (int)$check_year < 2010 || $invoice_detail_v1 || $invoice_detail_v2) {
                    // dd(!$get_invoice, (int)$check_year < 2010, $invoice_detail_v1, $invoice_detail_v2, $collection);
                    continue;
                }

                DB::transaction(function () use ($get_invoice, $collection) {
                    //version 1
                    $datas = array(
                        'invoice_detail_date' => Carbon::parse($collection[3])->toDateString(),
                        'version'             => 1,
                    );
                    $percentage = $this->_percentageRoofInvoiceDetail($get_invoice, $datas);

                    $datas = array(
                        'id_data'               => null,
                        'version'               => 1,
                        'category_id'           => Category::where('type', 'roof')->where('slug', $collection[1] ?? 'dr-shield')->where('version', 1)->first()?->id,
                        'invoice_detail_amount' => $collection[2],
                        'invoice_detail_date'   => Carbon::parse($collection[3])->toDateString(),
                        'percentage'            => $percentage,
                    );
                    $this->_roofInvoiceDetail($get_invoice, $datas);

                    $datas = array(
                        'version'             => 1,
                        'invoice_detail_date' => Carbon::parse($collection[3])->toDateString()
                    );
                    $this->_roofCommissionDetail($get_invoice, $datas);

                    //version 2
                    $datas = array(
                        'version'             => 2,
                        'invoice_detail_date' => Carbon::parse($collection[3])->toDateString(),
                    );
                    $percentage = $this->_percentageRoofInvoiceDetail($get_invoice, $datas);

                    $datas = array(
                        'id_data'               => null,
                        'version'               => 2,
                        'category_id'           => Category::where('type', 'roof')->where('slug', $collection[1] ?? 'dr-shield')->where('version', 2)->first()?->id,
                        'invoice_detail_amount' => $collection[2],
                        'invoice_detail_date'   => Carbon::parse($collection[3])->toDateString(),
                        'percentage'            => $percentage,
                    );
                    $this->_roofInvoiceDetail($get_invoice, $datas);

                    $datas = array(
                        'version'             => 2,
                        'invoice_detail_date' => Carbon::parse($collection[3])->toDateString()
                    );
                    $this->_roofCommissionDetail($get_invoice, $datas);

                });
            }
        } catch (Exception | Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            Log::error("Ada kesalahan saat import detail faktur atap");
        }
    }
}
