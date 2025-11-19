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
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Throwable;

class RoofInvoiceDetail implements ShouldQueue
{
    use Queueable;
    use GetSystemSetting, RoofInvoiceDetailProsses, RoofCommissionDetailProsses;

    public $tries = 5;                    // Max retry attempts
    public $timeout = 1200;                // 10 menit timeout
    public $maxExceptions = 3;            // Max exceptions before fail
    public $backoff = [60, 180, 300];     // Delay between retries (1min, 3min, 5min)
    public $failOnTimeout = true;         // Fail jika timeout

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
        // Set memory limit lebih tinggi
        // ini_set('memory_limit', '1024M');
        try {

            foreach ($this->collections as $key => $collection) {
                if ($key == 0) continue;

                    $get_invoice = Invoice::where('invoice_number', 'ILIKE', "%". $collection[0] ."%")->where('type', 'roof')->first();

                    $check_year = Carbon::parse($collection[2])->format('Y');

                    if (!$get_invoice || (int)$check_year < 2010) {
                        $warning = [
                                'invoice'     => !$get_invoice ? "Data faktur tidak ditemukan" : "aman",
                                'tanggal'     => (int) $check_year < 2010 ? "Format tanggal salah" : "aman",
                                'collections' => $collection
                            ];
                        Log::warning('Gagal memasukkan Detail Faktur Atap dengan no : ' . $collection[0], $warning);
                        continue;
                    }
                    Log::info('Berhasil memasukkan Detail Faktur Atap dengan no : '.$collection[0], ['collections' => $collection]);

                    DB::beginTransaction();
                        $this->invoiceDetailV1($get_invoice, $collection);
                        $this->invoiceDetailV2($get_invoice, $collection);
                    DB::commit();
            }

        } catch (Exception | Throwable $th) {
            DB::rollBack();
            $error = [
                'Import failed'          => $th->getMessage(),
                'Stack trace'            => $th->getTraceAsString(),
                'Job failed with memory' => memory_get_usage(true) / 1024 / 1024 . ' MB'
            ];
            Log::error("Ada kesalahan saat import detail faktur atap", $error);

            throw $th;
        }

        Log::info('Import Roof Invoice Detail berhasil');
    }

    public function failed(\Throwable $exception)
    {
        $error = [
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
            'collections_count' => count($this->collections),
            'memory_peak' => memory_get_peak_usage(true) / 1024 / 1024 . ' MB'
        ];
        Log::error('RoofInvoiceDetail permanently failed', $error);
    }

    private function invoiceDetailV1($get_invoice, $collection)
    {
        try {
            $categories = Category::where('type', 'roof')->where('version', 1)->get();

            $payment = $collection[1];

            foreach ($categories as $key => $category) {
                $value_payment_detail = (float) $get_invoice?->paymentDetails()->where('category_id', $category?->id)->sum('amount');

                $value_invoice_detail = (float) $get_invoice?->invoiceDetails()->where('category_id', $category?->id)->sum('amount');

                $get_category = $category;

                $remaining_price = $value_payment_detail - $value_invoice_detail;

                if ($value_invoice_detail >= $value_payment_detail) {
                    continue;
                }

                if ($remaining_price <= 0 || $payment <= 0) continue;

                $check_next_value_payment = $get_invoice?->paymentDetails()->where('category_id', Category::where('type', 'roof')->where('slug', $categories[$key + 1] ?? '')->where('version', 1)->first()?->id)->sum('amount');

                if ($check_next_value_payment) {
                    $invoice_amount = min($remaining_price, $payment);
                } else {
                    $invoice_amount = $payment;
                }
                    $datas = array(
                        'invoice_detail_date' => Carbon::parse($collection[2])->toDateString(),
                        'version'             => 1,
                    );
                    $percentage = $this->_percentageRoofInvoiceDetail($get_invoice, $datas);

                    $datas = array(
                        'id_data'               => null,
                        'version'               => 1,
                        'category_id'           => $get_category?->id,
                        'invoice_detail_amount' => $invoice_amount,
                        'invoice_detail_date'   => Carbon::parse($collection[2])->toDateString(),
                        'percentage'            => $percentage,
                    );
                    $this->_roofInvoiceDetail($get_invoice, $datas);
                    $payment -= $invoice_amount;

                    $datas = array(
                        'version'             => 1,
                        'invoice_detail_date' => Carbon::parse($collection[2])->toDateString()
                    );
                    $this->_roofCommissionDetail($get_invoice, $datas);
            }
        } catch (Exception | Throwable $th) {
            throw $th;
        }
    }

    private function invoiceDetailV2($get_invoice, $collection)
    {
        try {
            //version 2
            $datas = array(
                'version'             => 2,
                'invoice_detail_date' => Carbon::parse($collection[2])->toDateString(),
            );
            $percentage = $this->_percentageRoofInvoiceDetail($get_invoice, $datas);

            $category_id = $get_invoice?->paymentDetails()->whereNull('category_id')->where('version', 2)->where('amount', '>', 0)->first() ? null : $get_invoice?->paymentDetails()->whereNotNull('category_id')->where('version', 2)->where('amount', '>', 0)->first()?->category_id;

            $datas = array(
                'id_data'               => null,
                'version'               => 2,
                'category_id'           => $category_id,
                'invoice_detail_amount' => $collection[1],
                'invoice_detail_date'   => Carbon::parse($collection[2])->toDateString(),
                'percentage'            => $percentage,
            );
            $this->_roofInvoiceDetail($get_invoice, $datas);

            $datas = array(
                'version'             => 2,
                'invoice_detail_date' => Carbon::parse($collection[2])->toDateString()
            );
            $this->_roofCommissionDetail($get_invoice, $datas);
        } catch (Exception | Throwable $th) {
            throw $th;
        }
    }
}
