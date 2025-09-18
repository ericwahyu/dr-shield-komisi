<?php

namespace App\Jobs\Import\CeramicInvoice;

use App\Models\Invoice\Invoice;
use App\Traits\CommissionDetailProcess\CeramicCommissionDetailProsses;
use App\Traits\CommissionProcess;
use App\Traits\CommissionProcess\CeramicCommissionProsses;
use App\Traits\GetSystemSetting;
use App\Traits\InvoiceDetailProcess\CeramicInvoiceDetailProsses;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

use function Illuminate\Log\log;

class CeramicInvoiceDetail implements ShouldQueue
{
    use Queueable;
    use GetSystemSetting, CeramicInvoiceDetailProsses, CeramicCommissionDetailProsses;

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

                // $get_invoice = Invoice::where('invoice_number', $collection[0])->first();
                $get_invoice = Invoice::where('invoice_number', 'ILIKE', "%". $collection[0] ."%")->where('type', 'ceramic')->first();

                $check_year = Carbon::parse($collection[2])->format('Y');

                // $invoice_detail_v1 = $get_invoice?->invoiceDetails()->where('version', 1)->whereNull('category_id')->where('amount', (int)$collection[1])->where('date', Carbon::parse($collection[2])->toDateString())->first();
                // $invoice_detail_v2 = $get_invoice?->invoiceDetails()->where('version', 2)->whereNull('category_id')->where('amount', (int)$collection[1])->where('date', Carbon::parse($collection[2])->toDateString())->first();

                if (!$get_invoice || (int)$check_year < 2010) {
                     $warning = [
                        // 'get_user'        => !$get_user ? "Data sales tidak di temukan" : "Data sales ditemukan",
                        'invoice'     => !$get_invoice ? "Data faktur tidak ditemukan" : "aman",
                        'tanggal'     => (int) $check_year < 2010 ? "Format tanggal salah" : "aman",
                        'collections' => $collection
                    ];
                    Log::warning('Gagal memasukkan Detail Faktur Keramik dengan no : ' . $collection[0], $warning);
                    continue;
                }
                Log::info('Berhasil memasukkan Detail Faktur Keramik dengan no : '.$collection[0], ['collections' => $collection]);

                // version 1
                $datas = array(
                    'invoice_detail_date' => Carbon::parse($collection[2])->toDateString(),
                    'version'             => 1,
                );

                $percentage = $this->_percentageCeramicInvoiceDetail($get_invoice, $datas);

                $datas = array(
                    'id_data'               => null,
                    'version'               => 1,
                    'invoice_detail_amount' => $collection[1],
                    'invoice_detail_date'   => Carbon::parse($collection[2])->toDateString(),
                    'percentage'            => $percentage,
                );

                $this->_ceramicInvoiceDetail($get_invoice, $datas);

                $datas = array(
                    'version'             => 1,
                    'invoice_detail_date' => Carbon::parse($collection[2])->toDateString()
                );
                $this->_ceramicCommissionDetail($get_invoice, $datas);

                //version 2
                $datas = array(
                    'invoice_detail_date' => Carbon::parse($collection[2])->toDateString(),
                    'version'             => 2,
                );

                $percentage = $this->_percentageCeramicInvoiceDetail($get_invoice, $datas);

                $datas = array(
                    'id_data'               => null,
                    'version'               => 2,
                    'invoice_detail_amount' => $collection[1],
                    'invoice_detail_date'   => Carbon::parse($collection[2])->toDateString(),
                    'percentage'            => $percentage,
                );

                $this->_ceramicInvoiceDetail($get_invoice, $datas);

                $datas = array(
                    'version'             => 2,
                    'income_tax'          => $get_invoice?->income_tax,
                    'invoice_detail_date' => Carbon::parse($collection[2])->toDateString(),
                );
                $this->_ceramicCommissionDetail($get_invoice, $datas);
            }
        } catch (Exception | Throwable $th) {
            Log::error("Ada kesalahan saat import detail faktur keramik");
            throw new Exception($th->getMessage());
        }

        Log::info('Import Ceramic Invoice Detail berhasil');
    }
}
