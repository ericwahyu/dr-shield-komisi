<?php

namespace App\Imports\Invoice\RoofInvoice;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class RoofInvoiceCSVImport implements ToCollection, WithChunkReading, WithCustomCsvSettings, WithHeadingRow, ShouldQueue
{
    protected $file_faktur_path;
    protected $file_pembayaran_path;

    public function __construct($file_faktur_path, $file_pembayaran_path = null)
    {
        // Set memory dan time limit
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '600');

        // Store file paths (string) not file objects
        $this->file_faktur_path = $file_faktur_path;
        $this->file_pembayaran_path = $file_pembayaran_path;
    }

    public function collection(Collection $rows)
    {
        // Process faktur rows - convert heading row format ke index array
        $execution_import = new RoofInvoiceExecutionImport();

        // Convert dari heading row ke array biasa dengan index
        $converted_rows = new Collection();
        foreach ($rows as $row) {
            // Skip empty rows
            if ($row->filter()->isEmpty()) {
                continue;
            }

            // Convert to indexed array sesuai urutan kolom
            $converted_rows->push([
                $row['tanggal'] ?? $row['Tanggal'] ?? null,                    // [0] Tanggal
                $row['nomor'] ?? $row['Nomor #'] ?? null,                      // [1] Nomor #
                $row['pelanggan'] ?? $row['Pelanggan'] ?? null,                // [2] Pelanggan
                $row['dpp'] ?? $row['DPP'] ?? null,                            // [3] DPP (not used)
                $row['nilai_ppn'] ?? $row['Nilai PPN'] ?? null,                // [4] Nilai PPN (not used)
                $row['total'] ?? $row['Total'] ?? null,                        // [5] Total (not used)
                $row['kode'] ?? $row['kode'] ?? null,                          // [6] kode (depo)
                $row['nama_penjual_utama'] ?? $row['Nama Penjual Utama'] ?? null, // [7] Nama Penjual Utama
                $row['id_pelanggan_pelanggan'] ?? $row['ID Pelanggan Pelanggan'] ?? null, // [8] ID Pelanggan
                $row['masa_jatuh_tempo'] ?? $row['Masa Jatuh Tempo ()'] ?? null,  // [9] Masa Jatuh Tempo
                $this->cleanNumber($row['dpp_all'] ?? $row['DPP All'] ?? 0),              // [10] DPP All
                $this->cleanNumber($row['nilai_ppn_all'] ?? $row['Nilai PPN All'] ?? 0),  // [11] Nilai PPN All
                $this->cleanNumber($row['total_all'] ?? $row['Total all'] ?? 0),          // [12] Total all
                $this->cleanNumber($row['dpp_sonne'] ?? $row[' DPP sonne '] ?? 0),        // [13] DPP sonne
                $this->cleanNumber($row['nilai_ppn_sonne'] ?? $row['Nilai PPN sonne'] ?? 0), // [14] Nilai PPN sonne
                $this->cleanNumber($row['total_sonne'] ?? $row['Total sonne'] ?? 0),      // [15] Total sonne
                $this->cleanNumber($row['dpp_houz'] ?? $row['DPP Houz'] ?? 0),            // [16] DPP Houz
                $this->cleanNumber($row['nilai_ppn_sonne_2'] ?? $row['Nilai PPN sonne'] ?? 0), // [17] Nilai PPN Houz (typo di header)
                $this->cleanNumber($row['total_houz'] ?? $row['Total Houz'] ?? 0),        // [18] Total Houz
            ]);
        }

        $execution_import->collection($converted_rows);

        // Process pembayaran if file provided
        if ($this->file_pembayaran_path) {
            Log::info("Memulai queue import data pembayaran dari CSV...");
            $this->processPembayaran();
        }
    }

    protected function processPembayaran()
    {
        try {
            Log::info("Memulai queue import data pembayaran dari CSV", [
                'file_path' => $this->file_pembayaran_path,
                'file_exists' => file_exists($this->file_pembayaran_path) ? 'YES' : 'NO',
                'file_size' => file_exists($this->file_pembayaran_path) ? filesize($this->file_pembayaran_path) : 0,
                'current_working_directory' => getcwd()
            ]);

            // Import pembayaran dengan queue untuk reliability
            $pembayaran_import = new RoofInvoiceDetailCSVImport();
            \Maatwebsite\Excel\Facades\Excel::queueImport(
                $pembayaran_import,
                $this->file_pembayaran_path
            );

            Log::info("Data pembayaran dijadwalkan untuk diproses");
        } catch (\Exception $e) {
            Log::error("Gagal menjadwalkan proses data pembayaran: " . $e->getMessage());
        }
    }

    public function chunkSize(): int
    {
        return 50; // Process 50 rows at a time
    }

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
     * Specify the heading row is row 1 (first row)
     */
    public function headingRow(): int
    {
        return 1;
    }

    /**
     * Clean number format from Indonesian to standard
     * Example: "14.983.783,78" -> 14983783.78
     */
    private function cleanNumber($value)
    {
        if (empty($value)) {
            return 0;
        }

        // Remove spaces
        $value = trim($value);

        // Remove dots (thousands separator)
        $value = str_replace('.', '', $value);

        // Replace comma with dot (decimal separator)
        $value = str_replace(',', '.', $value);

        // Convert to float
        return (float) $value;
    }
}
