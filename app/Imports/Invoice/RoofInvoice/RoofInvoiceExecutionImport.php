<?php

namespace App\Imports\Invoice\RoofInvoice;

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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Throwable;

class RoofInvoiceExecutionImport implements ToCollection, WithChunkReading, WithCustomCsvSettings, ShouldQueue
{
    use GetSystemSetting, RoofCommissionProsses, RoofInvoiceProsses, RoofPaymentDetailProsses;

    /**
     * Configure CSV settings untuk semicolon delimiter
     */
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';',
            'enclosure' => '"',
            'escape' => '\\',
            'input_encoding' => 'UTF-8'
        ];
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collections)
    {
        // Set memory limit dan execution time
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '600');
        set_time_limit(600);
        gc_enable();

        $totalRows = $collections->count();
        $processedRows = 0;
        $successRows = 0;
        $errorRows = 0;

        Log::info("=== START Import Faktur Atap ===");
        Log::info("Total rows to process: " . $totalRows);

        $categories = Category::where('type', 'roof')->get();

        foreach ($collections as $key => $collection) {
            try {
                $this->processRow($collection, $categories);
                $successRows++;
                $processedRows++;

                // Log progress setiap 10 rows
                if ($processedRows % 10 == 0) {
                    Log::info("Progress: $processedRows/$totalRows rows processed");
                    gc_collect_cycles();
                }

            } catch (Exception | Throwable $th) {
                $errorRows++;
                $processedRows++;
                Log::error("Error processing row $key: " . $th->getMessage(), [
                    'row_data' => $collection,
                    'error_line' => $th->getLine(),
                    'error_file' => $th->getFile()
                ]);
                continue; // Skip error row, lanjut ke row berikutnya
            }
        }

        // Final summary
        Log::info("=== FINISH Import Faktur Atap ===");
        Log::info("Summary: Total=$totalRows, Success=$successRows, Error=$errorRows");

        // Clear memory setelah batch selesai
        unset($collections, $categories);
        gc_collect_cycles();
    }

    private function processRow($collection, $categories)
    {
        $get_user = User::where('name', $collection[7])
            ->whereHas('userDetail', function ($query) use ($collection) {
                $query->where('depo', 'ILIKE', '%'.$collection[6].'%')
                      ->where('sales_type', 'roof');
            })
            ->first();

        $unique_invoice = Invoice::where('invoice_number', $collection[1])->first();
        $check_year = Carbon::parse($collection[0])->format('Y');

        if (!$get_user || $unique_invoice || (int) $check_year < 2010) {
            $warning = [
                'sales'       => !$get_user ? "Data sales tidak ditemukan" : "Data sales ditemukan",
                'invoice'     => $unique_invoice ? "Data faktur sudah ada" : "aman",
                'tanggal'     => (int) $check_year < 2010 ? "Format tanggal salah" : "aman",
                'collections' => $collection
            ];
            Log::warning('Gagal memasukkan Faktur Atap dengan no : '.$collection[1], $warning);
            return;
        }

        // Calculate amounts
        $collection[12] = $collection[12] ?? (int) $collection[10] + (int) $collection[11];
        $collection[15] = $collection[15] ?? (int) $collection[13] + (int) $collection[14];
        $collection[18] = $collection[18] ?? (int) $collection[16] + (int) $collection[17];

        // Calculate income_tax
        $collection[10] = $collection[10] ?? (int) $collection[12] / 1.11;
        $collection[13] = $collection[13] ?? (int) $collection[15] / 1.11;
        $collection[16] = $collection[16] ?? (int) $collection[18] / 1.11;

        // Calculate value_tax
        $collection[11] = $collection[11] ?? (int) $collection[10] * 0.11;
        $collection[14] = $collection[14] ?? (int) $collection[13] * 0.11;
        $collection[17] = $collection[17] ?? (int) $collection[16] * 0.11;

        DB::transaction(function () use ($collection, $get_user, $categories) {
            $invoice = Invoice::create([
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
            ]);

            $payment_details = [
                'version_1' => [
                    'income_taxs' => [
                        'dr-shield' => (int) $collection[10] - (int) $collection[13] - (int) $collection[16],
                        'dr-sonne'  => (int) $collection[13],
                        'dr-houz'   => (int) $collection[16],
                    ],
                    'value_taxs' => [
                        'dr-shield' => (int) $collection[11] - (int) $collection[14] - (int) $collection[17],
                        'dr-sonne'  => (int) $collection[14],
                        'dr-houz'  => (int) $collection[17],
                    ],
                    'amounts' => [
                        'dr-shield' => (int) $collection[12] - (int) $collection[15] - (int) $collection[18],
                        'dr-sonne'  => (int) $collection[15],
                        'dr-houz'  => (int) $collection[18],
                    ],
                ],
                'version_2' => [
                    'income_taxs' => [
                        'dr-shield' => (int) $collection[10],
                        'dr-sonne'  => (int) $collection[13],
                    ],
                    'value_taxs' => [
                        'dr-shield' => (int) $collection[11],
                        'dr-sonne'  => (int) $collection[14],
                    ],
                    'amounts' => [
                        'dr-shield' => (int) $collection[12],
                        'dr-sonne'  => (int) $collection[15],
                    ],
                ],
            ];

            // Payment details version 1
            $this->_paymentDetail($invoice, [
                'version'     => 1,
                'income_taxs' => $payment_details['version_1']['income_taxs'],
                'value_taxs'  => $payment_details['version_1']['value_taxs'],
                'amounts'     => $payment_details['version_1']['amounts'],
            ]);

            // Payment details version 2
            $this->_paymentDetail($invoice, [
                'version'     => 2,
                'income_taxs' => $payment_details['version_2']['income_taxs'],
                'value_taxs'  => $payment_details['version_2']['value_taxs'],
                'amounts'     => $payment_details['version_2']['amounts'],
            ]);

            // Invoice Process version 1
            $this->_roofInvoice($invoice, [
                'version' => 1,
                'due_date' => $collection[9],
            ]);

            // Invoice Process version 2
            $this->_roofInvoice($invoice, [
                'version' => 2,
                'due_date' => $collection[9],
            ]);

            // Commission version 1
            $categories_v1 = Category::where('type', 'roof')->where('version', 1)->pluck('slug')->toArray();
            foreach ($categories_v1 as $category) {
                $get_category = Category::where('slug', $category)->where('version', 1)->first();
                $this->_roofCommission($invoice, $get_category, ['version' => 1]);
            }

            // Commission version 2
            $categories_v2 = [null, 'dr-sonne'];
            foreach ($categories_v2 as $category) {
                $get_category = Category::where('slug', $category)->where('version', 2)->first();
                $this->_roofCommission($invoice, $get_category, ['version' => 2]);
            }
        });

        Log::info('Berhasil memasukkan Faktur Atap dengan no : '.$collection[1]);
    }

    /**
     * Chunk reading untuk menghemat memory
     */
    public function chunkSize(): int
    {
        return 50; // Process 50 rows at a time
    }
}

