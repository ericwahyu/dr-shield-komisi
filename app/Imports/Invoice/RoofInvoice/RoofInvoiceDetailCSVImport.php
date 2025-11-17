<?php

namespace App\Imports\Invoice\RoofInvoice;

use App\Models\Invoice\Invoice;
use App\Models\System\Category;
use App\Traits\CommissionDetailProcess\RoofCommissionDetailProsses;
use App\Traits\GetSystemSetting;
use App\Traits\InvoiceDetailProcess\RoofInvoiceDetailProsses;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

class RoofInvoiceDetailCSVImport implements ToCollection, WithChunkReading, WithCustomCsvSettings, WithHeadingRow, ShouldQueue
{
    use GetSystemSetting, RoofInvoiceDetailProsses, RoofCommissionDetailProsses;

    public function collection(Collection $rows)
    {
        // Set memory dan execution time
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '600');
        set_time_limit(600);
        gc_enable();

        $totalRows = $rows->count();
        $processedRows = 0;
        $successRows = 0;
        $errorRows = 0;

        Log::info("Memulai proses import detail pembayaran. Total rows: {$totalRows}");

        try {
            foreach ($rows as $key => $row) {
                // Skip empty rows
                if (!$row || (is_object($row) && method_exists($row, 'filter') && $row->filter()->isEmpty())) {
                    continue;
                }

                $processedRows++;

                try {
                    // Convert heading row ke indexed array
                    $collection = [
                        $row['no_faktur'] ?? $row['No faktur'] ?? null,
                        $this->cleanNumber($row['nominal'] ?? $row['nominal'] ?? 0),
                        $row['tanggal'] ?? $row['tanggal'] ?? null,
                    ];

                    $this->processDetailRow($collection);
                    $successRows++;

                    // Log progress every 10 rows
                    if ($processedRows % 10 === 0) {
                        Log::info("Progress detail pembayaran: {$processedRows}/{$totalRows} rows processed");
                        gc_collect_cycles(); // Clean memory
                    }

                } catch (Exception | Throwable $e) {
                    $errorRows++;
                    Log::error("Error processing detail row {$processedRows}: " . $e->getMessage(), [
                        'row' => $collection ?? $row,
                        'error' => $e->getTraceAsString()
                    ]);
                }
            }

            Log::info("Import detail pembayaran selesai - debug 17/10/2025", [
                'total' => $totalRows,
                'processed' => $processedRows,
                'success' => $successRows,
                'errors' => $errorRows
            ]);

        } catch (Exception | Throwable $th) {
            Log::error('GAGAL Import detail pembayaran: ' . $th->getMessage(), [
                'error' => $th->getTraceAsString(),
                'processed_before_error' => $processedRows
            ]);
            throw $th;
        }

        // Final cleanup
        unset($rows);
        gc_collect_cycles();
    }

    private function processDetailRow($collection)
    {
        $get_invoice = Invoice::where('invoice_number', 'ILIKE', "%" . $collection[0] . "%")
            ->where('type', 'roof')
            ->first();

        $check_year = Carbon::parse($collection[2])->format('Y');

        if (!$get_invoice || (int) $check_year < 2010) {
            $warning = [
                'invoice'     => !$get_invoice ? "Data faktur tidak ditemukan" : "aman",
                'tanggal'     => (int) $check_year < 2010 ? "Format tanggal salah" : "aman",
                'collections' => $collection
            ];
            Log::warning('Gagal memasukkan Detail Faktur Atap dengan no : ' . $collection[0], $warning);
            return;
        }

        Log::info('Berhasil memasukkan Detail Faktur Atap dengan no : ' . $collection[0], ['collections' => $collection]);

        DB::transaction(function () use ($get_invoice, $collection) {
            $this->invoiceDetailV1($get_invoice, $collection);
            $this->invoiceDetailV2($get_invoice, $collection);
        });
    }

    private function invoiceDetailV1($get_invoice, $collection)
    {
        try {
            $categories = Category::where('type', 'roof')->where('version', 1)->get();

            $payment = (int) $collection[1];

            foreach ($categories as $key => $category) {
                $value_payment_detail = $get_invoice?->paymentDetails()->where('category_id', $category?->id)->sum('amount');

                $value_invoice_detail = $get_invoice?->invoiceDetails()->where('category_id', $category?->id)->sum('amount');

                $get_category = $category;

                $remaining_price = (int) $value_payment_detail - (int) $value_invoice_detail;

                if ((int) $value_invoice_detail >= (int) $value_payment_detail) {
                    continue;
                }

                if ($remaining_price <= 0 || $payment <= 0) continue;

                $next_category = $categories[$key + 1] ?? null;
                $check_next_value_payment = 0;

                if ($next_category) {
                    $check_next_value_payment = $get_invoice?->paymentDetails()
                        ->where('category_id', $next_category->id)
                        ->sum('amount');
                }

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
                    'invoice_detail_amount' => (int) $invoice_amount,
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
            Log::info('=== START invoiceDetailV2 ===', [
                'invoice_id' => $get_invoice->id,
                'invoice_no' => $get_invoice->invoice_number,
                'payment_amount' => $collection[1],
            ]);

            //version 2
            $datas = array(
                'version'             => 2,
                'invoice_detail_date' => Carbon::parse($collection[2])->toDateString(),
            );
            $percentage = $this->_percentageRoofInvoiceDetail($get_invoice, $datas);

            $category_id = $get_invoice?->paymentDetails()->whereNull('category_id')->where('version', 2)->where('amount', '>', 0)->first() ? null : $get_invoice?->paymentDetails()->whereNotNull('category_id')->where('version', 2)->where('amount', '>', 0)->first()?->category_id;

            Log::info('V2 Processing payment', [
                'category_id' => $category_id,
                'amount' => $collection[1],
            ]);

            $datas = array(
                'id_data'               => null,
                'version'               => 2,
                'category_id'           => $category_id,
                'invoice_detail_amount' => $collection[1],
                'invoice_detail_date'   => Carbon::parse($collection[2])->toDateString(),
                'percentage'            => $percentage,
            );
            $this->_roofInvoiceDetail($get_invoice, $datas);

            Log::info('V2 Invoice detail created');

            $datas = array(
                'version'             => 2,
                'invoice_detail_date' => Carbon::parse($collection[2])->toDateString()
            );
            $this->_roofCommissionDetail($get_invoice, $datas);

            Log::info('V2 Commission detail created');

            Log::info('=== END invoiceDetailV2 ===');
        } catch (Exception | Throwable $th) {
            throw $th;
        }
    }

    public function chunkSize(): int
    {
        return 50;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';',
            'enclosure' => '"',
            'escape' => '\\',
            'input_encoding' => 'UTF-8'
        ];
    }

    public function headingRow(): int
    {
        return 1;
    }

    private function cleanNumber($value)
    {
        if (empty($value)) {
            return 0;
        }

        // Remove spaces
        $value = trim($value);

        // Remove dots (thousands separator)
        $value = str_replace('.', '', $value);

        // Remove comma (decimal separator, tapi untuk nominal biasanya tidak ada desimal)
        $value = str_replace(',', '', $value);

        // Convert to int
        return (int) $value;
    }
}
