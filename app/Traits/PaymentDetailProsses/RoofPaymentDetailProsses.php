<?php

namespace App\Traits\PaymentDetailProsses;

use App\Models\System\Category;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

trait RoofPaymentDetailProsses
{
    //
    public function _paymentDetail($invoice, $datas)
    {
        try {
            if ($datas['version'] == 1) {
                $this->_paymentDetailV1($invoice, $datas);
            } elseif ($datas['version'] == 2) {
                $this->_paymentDetailV2($invoice, $datas);
            }
        } catch (Exception | Throwable $th) {
            Log::error("Ada kesalahan saat proses payment detail");
            throw new Exception($th->getMessage());
        }
    }

    public function _paymentDetailV1($invoice, $datas)
    {
        try {
            $categories = ['dr-shield', 'dr-sonne', 'dr-houz'];

            foreach ($categories as $key => $category) {
                $invoice->paymentDetails()->updateOrCreate(
                    [
                        'category_id' => Category::where('slug', $category)->where('version', 1)->first()?->id
                    ],
                    [
                        'category_id' => Category::where('slug', $category)->where('version', 1)->first()?->id,
                        'version'     => 1,
                        'income_tax'  => isset($datas['income_taxs'][$category]) ? (int)number_format($datas['income_taxs'][$category], 0, ',', '') : null,
                        'value_tax'   => isset($datas['value_taxs'][$category]) ? (int)number_format($datas['value_taxs'][$category], 0, ',', '') : null,
                        'amount'      => isset($datas['amounts'][$category]) ? (int)number_format($datas['amounts'][$category], 0, ',', '') : null,
                    ]
                );
            }
        } catch (Exception | Throwable $th) {
            Log::error("Ada kesalahan saat proses payment detail v1");
            throw new Exception($th->getMessage());
        }
    }
    public function _paymentDetailV2($invoice, $datas)
    {
        try {

            $categories = [null, 'dr-sonne'];

            foreach ($categories as $key => $category) {
                $category = $category == null ? 'dr-shield' : $category;
                $invoice->paymentDetails()->updateOrCreate(
                    [
                        'category_id' => Category::where('slug', $category)->where('version', 2)->first()?->id
                    ],
                    [
                        'category_id' => Category::where('slug', $category)->where('version', 2)->first()?->id,
                        'version'     => 2,
                        'income_tax'  => isset($datas['income_taxs'][$category]) ? (int)number_format($datas['income_taxs'][$category], 0, ',', '') : null,
                        'value_tax'   => isset($datas['value_taxs'][$category]) ? (int)number_format($datas['value_taxs'][$category], 0, ',', '') : null,
                        'amount'      => isset($datas['amounts'][$category]) ? (int)number_format($datas['amounts'][$category], 0, ',', '') : null,
                    ]
                );
            }
        } catch (\Throwable $th) {
            Log::error("Ada kesalahan saat proses payment detail v2");
            throw new Exception($th->getMessage());
        }
    }
}
