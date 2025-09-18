<?php

namespace App\Jobs\Import\RoofInvoice;

use App\Models\Auth\User;
use App\Models\Invoice\Invoice;
use App\Models\System\Category;
use App\Traits\CommissionProcess\RoofCommissionProsses;
use App\Traits\GetSystemSetting;
use App\Traits\InvoiceProcess\RoofInvoiceProsses;
use App\Traits\PaymentDetailProsses\RoofPaymentDetailProsses;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class RoofInvoice implements ShouldQueue
{
    use GetSystemSetting, RoofCommissionProsses, RoofInvoiceProsses, RoofPaymentDetailProsses;
    use Queueable;

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
        ini_set('memory_limit', '1024M');

        try {
            $categories = Category::where('type', 'roof')->get();
             // Process dalam chunks untuk data besar
            // $chunks = $this->collections->chunk(50); // 50 items per chunk
            // foreach ($chunks as $chunkIndex => $chunk) {
            //     Log::info("Processing chunk {$chunkIndex}, memory: " . memory_get_usage(true) / 1024 / 1024 . " MB");

            //     unset($chunk);
            //     gc_collect_cycles();
            // }
            foreach ($this->collections as $key => $collection) {
                if ($key == 0) {
                    continue;
                }

                $get_user = User::where('name', 'ILIKE', '%'.$collection[7].'%')->whereHas('userDetail', function ($query) use ($collection) {
                    $query->where('depo', 'ILIKE', '%'.$collection[6].'%')->where('sales_type', 'roof');
                })->first();

                $unique_invoice = Invoice::where('invoice_number', $collection[1])->first();

                $check_year = Carbon::parse($collection[0])->format('Y');

                if (!$get_user || $unique_invoice || (int) $check_year < 2010) {
                    $warning = [
                        'sales'       => !$get_user ? "Data sales tidak di temukan" : "Data sales ditemukan",
                        'invoice'     => $unique_invoice ? "Data faktur sudah ada" : "aman",
                        'tanggal'     => (int) $check_year < 2010 ? "Format tanggal salah" : "aman",
                        'collections' => $collection
                    ];
                    Log::warning('Gagal memasukkan Faktur Atap dengan no : '.$collection[1], $warning);

                    continue;
                }
                Log::info('Berhasil memasukkan Faktur Atap dengan no : '.$collection[1], ['collections' => $collection]);

                //amount
                $collection[12] = $collection[12] == null ? (int) $collection[10] + (int) $collection[11] : (int) $collection[12];
                $collection[15] = $collection[15] == null ? (int) $collection[13] + (int) $collection[14] : (int) $collection[15];
                $collection[18] = $collection[18] == null ? (int) $collection[16] + (int) $collection[17] : (int) $collection[18];

                //income_tax
                $collection[10] = $collection[10] == null ? (int) $collection[12] / 1.11 : (int) $collection[10];
                $collection[13] = $collection[13] == null ? (int) $collection[15] / 1.11 : (int) $collection[13];
                $collection[16] = $collection[16] == null ? (int) $collection[18] / 1.11 : (int) $collection[16];

                //value_tax
                $collection[11] = $collection[11] == null ? (int) $collection[10] * 0.11 : (int) $collection[11];
                $collection[14] = $collection[14] == null ? (int) $collection[13] * 0.11 : (int) $collection[14];
                $collection[17] = $collection[17] == null ? (int) $collection[16] * 0.11 : (int) $collection[17];


                DB::transaction(function () use ($collection, $get_user, $categories) {

                    $invoice = Invoice::create(
                        [
                            'user_id'        => $get_user?->id,
                            'type'           => 'roof',
                            'date'           => $collection[0],
                            'invoice_number' => $collection[1],
                            'customer'       => $collection[2],
                            'id_customer'    => $collection[8],
                            'income_tax'     => (int) $collection[10] - (int) $collection[13] + (int) $collection[13],
                            'value_tax'      => (int) $collection[11] - (int) $collection[14] + (int) $collection[14],
                            'amount'         => (int) $collection[12] - (int) $collection[15] + (int) $collection[15],
                            'due_date'       => $collection[9] ?? 30,
                        ]
                    );

                    $payment_details = [
                        'version_1' => [
                            'income_taxs' => [
                                // 'dr-shield' => max(0, (int)$collection[10] - (int)$collection[13]),
                                'dr-shield' => (int) $collection[10] - (int) $collection[13] - (int) $collection[16],
                                'dr-sonne'  => (int) $collection[13],
                                // 'dr-houz'   => (int) $collection[10] - (int) $collection[13] - ((int) $collection[10] - (int) $collection[13]),
                                'dr-houz'   => (int) $collection[16],
                            ],
                            'value_taxs' => [
                                // 'dr-shield' => max(0, (int)$collection[11] - (int)$collection[14]),
                                'dr-shield' => (int) $collection[11] - (int) $collection[14] - (int) $collection[17],
                                'dr-sonne'  => (int) $collection[14],
                                // 'dr-houz'  => (int) $collection[11] - (int) $collection[14] - ((int) $collection[11] - (int) $collection[14]),
                                'dr-houz'  => (int) $collection[17],
                            ],
                            'amounts' => [
                                // 'dr-shield' => max(0, (int)$collection[12] - (int)$collection[15]),
                                'dr-shield' => (int) $collection[12] - (int) $collection[15] - (int) $collection[18],
                                'dr-sonne'  => (int) $collection[15],
                                // 'dr-houz'  => (int) $collection[12] - (int) $collection[15] - ((int) $collection[12] - (int) $collection[15]),
                                'dr-houz'  => (int) $collection[18],
                            ],
                        ],
                        'version_2' => [
                            'income_taxs' => [
                                // 'dr-shield' => max(0, (int)$collection[10] - (int)$collection[13]),
                                'dr-shield' => (int) $collection[10],
                                'dr-sonne'  => (int) $collection[13],
                                // 'dr-houz'   => (int)$collection[13],
                            ],
                            'value_taxs' => [
                                // 'dr-shield' => max(0, (int)$collection[11] - (int)$collection[14]),
                                'dr-shield' => (int) $collection[11],
                                'dr-sonne'  => (int) $collection[14],
                            ],
                            'amounts' => [
                                // 'dr-shield' => max(0, (int)$collection[12] - (int)$collection[15]),
                                'dr-shield' => (int) $collection[12],
                                'dr-sonne'  => (int) $collection[15],
                            ],
                        ],
                    ];

                    $datas = [
                        'version'     => 1,
                        'income_taxs' => $payment_details['version_1']['income_taxs'],
                        'value_taxs'  => $payment_details['version_1']['value_taxs'],
                        'amounts'     => $payment_details['version_1']['amounts'],
                    ];

                    $this->_paymentDetail($invoice, $datas);

                    $datas = [
                        'version'     => 2,
                        'income_taxs' => $payment_details['version_2']['income_taxs'],
                        'value_taxs'  => $payment_details['version_2']['value_taxs'],
                        'amounts'     => $payment_details['version_2']['amounts'],
                    ];
                    $this->_paymentDetail($invoice, $datas);

                    //Invoice Proses
                    $datas = [
                        'version' => 1,
                        'due_date' => $collection[9],
                    ];
                    $this->_roofInvoice($invoice, $datas);

                    $datas = [
                        'version' => 2,
                        'due_date' => $collection[9],
                    ];
                    $this->_roofInvoice($invoice, $datas);

                    $categories = Category::where('type', 'roof')->where('version', 1)->pluck('slug')->toArray();
                    foreach ($categories as $key => $category) {
                        $get_category = Category::where('slug', $category)->where('version', 1)->first();
                        $datas = [
                            'version' => 1,
                        ];
                        $this->_roofCommission($invoice, $get_category, $datas);
                    }

                    $categories = [null, 'dr-sonne'];
                    foreach ($categories as $key => $category) {
                        $get_category = Category::where('slug', $category)->where('version', 2)->first();
                        $datas = [
                            'version' => 2,
                        ];
                        $this->_roofCommission($invoice, $get_category, $datas);
                    }
                });
            }
        } catch (Exception|Throwable $th) {
            DB::rollBack();
            $error = [
                'message' => json_decode($th->getMessage()),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'Stack trace'            => $th->getTraceAsString(),
                'Job failed with memory' => memory_get_usage(true) / 1024 / 1024 . ' MB'
            ];
            Log::error('Ada kesalahan saat import faktur atap', $error);
            throw $th;
        }

        Log::info('Import Roof Invoice berhasil');
    }

    public function failed(\Throwable $exception)
    {
        $error = [
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
            'collections_count' => count($this->collections),
            'memory_peak' => memory_get_peak_usage(true) / 1024 / 1024 . ' MB'
        ];
        Log::error('RoofInvoice permanently failed', $error);
    }

    private function createDueDateRule($invoice, $due_date)
    {
        $data_due_dates = [
            [
                'due_date' => 0,
                'value' => 100,
            ],
            [
                'due_date' => 15,
                'value' => 50,
            ],
            [
                'due_date' => 7,
                'value' => 0,
            ],
        ];

        foreach ($data_due_dates as $key => $data_due_date) {
            if ($key == 0) {
                $invoice->dueDateRules()->create(
                    [
                        'type' => 'roof',
                        'due_date' => $data_due_date['due_date'],
                        'value' => $data_due_date['value'],
                    ]
                );
            } elseif ($key == 1) {
                $invoice->dueDateRules()->create(
                    [
                        'type' => 'roof',
                        'due_date' => $due_date <= 30 ? 30 + (int) $data_due_date['due_date'] : (int) $due_date + (int) $data_due_date['due_date'],
                        'value' => $data_due_date['value'],
                    ]
                );
            } elseif ($key > 1) {
                $get_due_date_rule = $invoice->dueDateRules()->orderBy('value', 'ASC')->first();
                $invoice->dueDateRules()->create(
                    [
                        'type' => 'roof',
                        'due_date' => (int) $get_due_date_rule?->due_date + (int) $data_due_date['due_date'],
                        'value' => $data_due_date['value'],
                    ]
                );
            }
        }
    }
}
