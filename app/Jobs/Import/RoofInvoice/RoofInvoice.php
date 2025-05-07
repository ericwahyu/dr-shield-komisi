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

        $categories = Category::where('type', 'roof')->get();
        try {
            foreach ($this->collections as $key => $collection) {
                if ($key == 0) {
                    continue;
                }
                // dd($collection);

                $get_user = User::where('name', 'ILIKE', '%'.$collection[7].'%')->whereHas('userDetail', function ($query) use ($collection) {
                    $query->where('depo', 'ILIKE', '%'.$collection[6].'%');
                })->first();

                $unique_invoice = Invoice::where('invoice_number', $collection[1])->first();

                $check_year = Carbon::parse($collection[0])->format('Y');

                if (!$get_user || $unique_invoice || (int) $check_year < 2010) {
                    Log::warning('Gagal memasukkan Faktur Atap dengan no : '.$collection[1]);
                    // Log::warning('user notfound : '.!$get_user ? 'true' : 'false');
                    // Log::warning('unique invoice : '.$unique_invoice ? 'true' : 'false');
                    // Log::warning('invoice year : '.$check_year);
                    continue;
                }

                //value_tax
                $collection[11] = $collection[11] == null ? $collection[10] * 0.11 : $collection[11];
                $collection[14] = $collection[14] == null ? $collection[13] * 0.11 : $collection[14];

                //amount
                $collection[12] = $collection[12] == null ? $collection[10] + $collection[11] : $collection[12];
                $collection[15] = $collection[15] == null ? $collection[13] + $collection[14] : $collection[15];

                DB::transaction(function () use ($collection, $get_user, $categories) {

                    $invoice = Invoice::create(
                        [
                            'user_id' => $get_user?->id,
                            'type' => 'roof',
                            'date' => $collection[0],
                            'invoice_number' => $collection[1],
                            'customer' => $collection[2],
                            'id_customer' => $collection[8],
                            'income_tax' => (int) $collection[10] + (int) $collection[13],
                            'value_tax' => (int) $collection[11] + (int) $collection[14],
                            'amount' => (int) $collection[12] + (int) $collection[15],
                            'due_date' => $collection[9] ?? 30,
                        ]
                    );

                    $income_taxs = [
                        'dr-shield' => (int) $collection[10],
                        'dr-sonne' => (int) $collection[13],
                    ];

                    $value_taxs = [
                        'dr-shield' => (int) $collection[11],
                        'dr-sonne' => (int) $collection[14],
                    ];

                    $amounts = [
                        'dr-shield' => (int) $collection[12],
                        'dr-sonne' => (int) $collection[15],
                    ];

                    $datas = [
                        'version' => 1,
                        'income_taxs' => $income_taxs,
                        'value_taxs' => $value_taxs,
                        'amounts' => $amounts,
                    ];

                    $this->_paymentDetail($invoice, $datas);

                    $datas = [
                        'version' => 2,
                        'income_taxs' => $income_taxs,
                        'value_taxs' => $value_taxs,
                        'amounts' => $amounts,
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

                    $categories = ['dr-shield', 'dr-sonne'];
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
                'file'    => $th->getFile(),
                'line'    => $th->getLine(),
            ];
            Log::error("Ada kesalahan saat import faktur atap", $error);
        }

        Log::info('Import Roof Invoice berhasil');
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
                        'type'     => 'roof',
                        'due_date' => $due_date <= 30 ? 30 + (int) $data_due_date['due_date'] : (int) $due_date + (int) $data_due_date['due_date'],
                        'value'    => $data_due_date['value'],
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
