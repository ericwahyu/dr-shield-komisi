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

                $check_year = Carbon::parse($collection[2])->format('Y');

                if (!$get_invoice || (int)$check_year < 2010) {
                    $warning = [
                        'get_invoice'     => !$get_invoice,
                        'year_under_2010' => (int)$check_year < 2010,
                    ];
                    Log::warning('Gagal memasukkan Detail Faktur Atap dengan no : '.$collection[1], $warning);
                    continue;
                }

                $this->invoiceDetailV1($get_invoice, $collection);
                $this->invoiceDetailV2($get_invoice, $collection);

            }
        } catch (Exception | Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            Log::error("Ada kesalahan saat import detail faktur atap");
        }

        Log::info('Import Roof Invoice Detail berhasil');
    }

    private function invoiceDetailV1($get_invoice, $collection)
    {
        try {
            $dr_shield_category = Category::where('type', 'roof')->where('slug', 'dr-shield')->where('version', 1)->first();

            $dr_sonne_category = Category::where('type', 'roof')->where('slug', 'dr-sonne')->where('version', 1)->first();

            $value_payment_of_dr_shield = $get_invoice?->paymentDetails()->where('category_id', $dr_shield_category?->id)->sum('amount');

            $value_payment_of_dr_sonne = $get_invoice?->paymentDetails()->where('category_id', $dr_sonne_category?->id)->sum('amount');

            $sum_payment = (int)$value_payment_of_dr_shield + (int)$value_payment_of_dr_sonne;

            $value_invoice_of_dr_shield = $get_invoice->invoiceDetails()->where('category_id', $dr_shield_category?->id)->sum('amount');

            $value_invoice_of_dr_sonne = $get_invoice->invoiceDetails()->where('category_id', $dr_sonne_category?->id)->sum('amount');

            $sum_value_invoice = (int)$value_invoice_of_dr_shield + (int)$value_invoice_of_dr_sonne;

            if ((int)$sum_value_invoice + $collection[1] < (int)$sum_payment + 10000) {

                DB::beginTransaction();
                    $datas = array(
                        'invoice_detail_date' => Carbon::parse($collection[2])->toDateString(),
                        'version'             => 1,
                    );
                    $percentage = $this->_percentageRoofInvoiceDetail($get_invoice, $datas);

                    if ((int)$value_payment_of_dr_shield > 0) {

                        $value_invoice_of_dr_shield = $get_invoice->invoiceDetails()->where('category_id', $dr_shield_category?->id)->sum('amount');

                        if ((int)$value_invoice_of_dr_shield + (int)$collection[1] < (int)$value_payment_of_dr_shield || (int)$value_payment_of_dr_sonne == 0) {

                            $datas = array(
                                'id_data'               => null,
                                'version'               => 1,
                                'category_id'           => Category::where('type', 'roof')->where('slug', 'dr-shield')->where('version', 1)->first()?->id,
                                'invoice_detail_amount' => $collection[1],
                                'invoice_detail_date'   => Carbon::parse($collection[2])->toDateString(),
                                'percentage'            => $percentage,
                            );
                            $this->_roofInvoiceDetail($get_invoice, $datas);

                        } else {
                            $value_for_dr_shield = (int)$value_payment_of_dr_shield - (int)$value_invoice_of_dr_shield;

                            $datas = array(
                                'id_data'               => null,
                                'version'               => 1,
                                'category_id'           => Category::where('type', 'roof')->where('slug', 'dr-shield')->where('version', 1)->first()?->id,
                                'invoice_detail_amount' => $value_for_dr_shield,
                                'invoice_detail_date'   => Carbon::parse($collection[2])->toDateString(),
                                'percentage'            => $percentage,
                            );
                            $this->_roofInvoiceDetail($get_invoice, $datas);

                            $value_for_dr_sonne = (int)$collection[1] - (int)$value_for_dr_shield;
                            $datas = array(
                                'id_data'               => null,
                                'version'               => 1,
                                'category_id'           => Category::where('type', 'roof')->where('slug', 'dr-sonne')->where('version', 1)->first()?->id,
                                'invoice_detail_amount' => $value_for_dr_sonne,
                                'invoice_detail_date'   => Carbon::parse($collection[2])->toDateString(),
                                'percentage'            => $percentage,
                            );
                            $this->_roofInvoiceDetail($get_invoice, $datas);
                        }

                    } else {

                        $datas = array(
                            'id_data'               => null,
                            'version'               => 1,
                            'category_id'           => Category::where('type', 'roof')->where('slug', 'dr-sonne')->where('version', 1)->first()?->id,
                            'invoice_detail_amount' => $collection[1],
                            'invoice_detail_date'   => Carbon::parse($collection[2])->toDateString(),
                            'percentage'            => $percentage,
                        );
                        $this->_roofInvoiceDetail($get_invoice, $datas);
                    }

                    $datas = array(
                        'version'             => 1,
                        'invoice_detail_date' => Carbon::parse($collection[2])->toDateString()
                    );
                    $this->_roofCommissionDetail($get_invoice, $datas);
                DB::commit();
            }

        } catch (Exception | Throwable $th) {
            throw $th;
        }
    }

    private function invoiceDetailV2($get_invoice, $collection)
    {
        try {
            $dr_shield_category = Category::where('type', 'roof')->where('slug', 'dr-shield')->where('version', 2)->first();

            $dr_sonne_category = Category::where('type', 'roof')->where('slug', 'dr-sonne')->where('version', 2)->first();

            $value_payment_of_dr_shield = $get_invoice?->paymentDetails()->where('category_id', $dr_shield_category?->id)->sum('amount');

            $value_payment_of_dr_sonne = $get_invoice?->paymentDetails()->where('category_id', $dr_sonne_category?->id)->sum('amount');

            $sum_payment = (int)$value_payment_of_dr_shield + (int)$value_payment_of_dr_sonne;

            $value_invoice_of_dr_shield = $get_invoice->invoiceDetails()->where('category_id', $dr_shield_category?->id)->sum('amount');

            $value_invoice_of_dr_sonne = $get_invoice->invoiceDetails()->where('category_id', $dr_sonne_category?->id)->sum('amount');

            $sum_value_invoice = (int)$value_invoice_of_dr_shield + (int)$value_invoice_of_dr_sonne;

            if ((int)$sum_value_invoice + $collection[1] < (int)$sum_payment + 10000) {
                DB::beginTransaction();
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
                        // 'category_id'           => Category::where('type', 'roof')->where('slug', $collection[1] ?? 'dr-shield')->where('version', 2)->first()?->id,
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
                DB::commit();
            }

        } catch (Exception | Throwable $th) {
            throw $th;
        }
    }
}
