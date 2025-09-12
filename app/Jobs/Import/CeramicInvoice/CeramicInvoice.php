<?php

namespace App\Jobs\Import\CeramicInvoice;

use App\Models\Auth\User;
use App\Models\Invoice\DueDateRuleCeramic;
use App\Models\Invoice\Invoice;
use App\Traits\CommissionProcess;
use App\Traits\CommissionProcess\CeramicCommissionProsses;
use App\Traits\GetSystemSetting;
use App\Traits\InvoiceProcess\CeramicInvoiceProsses;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CeramicInvoice implements ShouldQueue
{
    use Queueable;
    use GetSystemSetting, CeramicInvoiceProsses, CeramicCommissionProsses;

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

                $get_user = User::where('name', 'ILIKE', "%". $collection[7] ."%")->whereHas('userDetail', function ($query) use ($collection) {
                    $query->where('depo', 'ILIKE', "%". $collection[6] ."%");
                })->first();

                $check_lower_limit = $get_user?->lowerLimits()->whereNull('category_id')->first();

                $unique_invoice = Invoice::where('invoice_number', $collection[1])->first();

                $check_year = Carbon::parse($collection[0])->format('Y');

                // dd($collection[7],  $collection[6], $get_user);

                if (!$get_user || $unique_invoice || (int)$check_year < 2010) {
                     $warning = [
                        'sales'       => !$get_user ? "Data sales tidak di temukan" : "aman",
                        'invoice'     => $unique_invoice ? "Data faktur sudah ada" : "aman",
                        'tanggal'     => (int) $check_year < 2010 ? "Format tanggal salah" : "aman",
                        'collections' => $collection
                    ];
                    Log::warning('Gagal memasukkan Faktur Keramik dengan no : '.$collection[1], $warning);
                    continue;
                }

                DB::transaction(function () use ($get_user, $collection) {
                    $invoice = Invoice::create(
                        [
                            'user_id'        => $get_user?->id,
                            'type'           => 'ceramic',
                            'date'           => $collection[0],
                            'invoice_number' => $collection[1],
                            'customer'       => $collection[2],
                            'id_customer'    => $collection[8],
                            'income_tax'     => (int)$collection[3],
                            'value_tax'      => (int)$collection[4],
                            'amount'         => (int)$collection[5],
                            'due_date'       => $collection[9],
                        ]
                    );

                    $invoice->paymentDetails()->create(
                        [
                           'category_id' => null,
                           'version'     => 1,
                           'income_tax'     => (int)$collection[3],
                           'value_tax'      => (int)$collection[4],
                           'amount'         => (int)$collection[5],
                        ]
                    );

                    $invoice->paymentDetails()->create(
                        [
                           'category_id' => null,
                           'version'     => 2,
                           'income_tax'     => (int)$collection[3],
                           'value_tax'      => (int)$collection[4],
                           'amount'         => (int)$collection[5],
                        ]
                    );

                     //proses invoice
                    $datas = array(
                        'due_date' =>  $collection[9],
                        'version'  => 1,
                    );
                    $this->_ceramicInvoice($invoice, $datas);

                    $datas = array(
                        'due_date' =>  $collection[9],
                        'version'  => 2,
                    );
                    $this->_ceramicInvoice($invoice, $datas);

                    //create commission
                    $datas = array(
                        'income_tax' => (int)$collection[3],
                        'version'    => 1,
                    );
                    $this->_ceramicCommission($invoice, $datas);

                    $datas = array(
                        'income_tax' => (int)$collection[3],
                        'version'    => 2,
                    );
                    $this->_ceramicCommission($invoice, $datas);
                });
            }

        } catch (Exception | Throwable $th) {
            DB::rollBack();
            Log::error("Ada kesalahan saat import faktur keramik");
            throw new Exception($th->getMessage());
        }

        Log::info('Import Ceramic Invoice berhasil');
    }
}
