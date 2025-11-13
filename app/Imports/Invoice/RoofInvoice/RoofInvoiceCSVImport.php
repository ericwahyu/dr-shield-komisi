<?php

namespace App\Imports\Invoice\RoofInvoice;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use Illuminate\Support\Collection;

class RoofInvoiceCSVImport implements ToCollection, WithChunkReading, WithCustomCsvSettings, WithHeadingRow, WithEvents, ShouldQueue
{
    protected $file_faktur_path;
    protected $file_pembayaran_path;

    public function __construct($file_faktur_path, $file_pembayaran_path = null)
    {
        // Set memory dan time limit
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '600');

        $this->file_faktur_path = $file_faktur_path;
        $this->file_pembayaran_path = $file_pembayaran_path;
    }

    public function collection(Collection $rows)
    {
        $execution_import = new RoofInvoiceExecutionImport();

        $converted_rows = new Collection();
        foreach ($rows as $row) {
            // Skip empty rows
            if ($row->filter()->isEmpty()) {
                continue;
            }

            $converted_rows->push([
                $row['tanggal'] ?? $row['Tanggal'] ?? null,
                $row['nomor'] ?? $row['Nomor #'] ?? null,
                $row['pelanggan'] ?? $row['Pelanggan'] ?? null,
                $row['dpp'] ?? $row['DPP'] ?? null,
                $row['nilai_ppn'] ?? $row['Nilai PPN'] ?? null,
                $row['total'] ?? $row['Total'] ?? null,
                $row['kode'] ?? $row['kode'] ?? null,
                $row['nama_penjual_utama'] ?? $row['Nama Penjual Utama'] ?? null,
                $row['id_pelanggan_pelanggan'] ?? $row['ID Pelanggan Pelanggan'] ?? null,
                $row['masa_jatuh_tempo'] ?? $row['Masa Jatuh Tempo ()'] ?? null,
                $this->cleanNumber($row['dpp_all'] ?? $row['DPP All'] ?? 0),
                $this->cleanNumber($row['nilai_ppn_all'] ?? $row['Nilai PPN All'] ?? 0),
                $this->cleanNumber($row['total_all'] ?? $row['Total all'] ?? 0),
                $this->cleanNumber($row['dpp_sonne'] ?? $row[' DPP sonne '] ?? 0),
                $this->cleanNumber($row['nilai_ppn_sonne'] ?? $row['Nilai PPN sonne'] ?? 0),
                $this->cleanNumber($row['total_sonne'] ?? $row['Total sonne'] ?? 0),
                $this->cleanNumber($row['dpp_houz'] ?? $row['DPP Houz'] ?? 0),
                $this->cleanNumber($row['nilai_ppn_sonne_2'] ?? $row['Nilai PPN sonne'] ?? 0),
                $this->cleanNumber($row['total_houz'] ?? $row['Total Houz'] ?? 0),
            ]);
        }

        $execution_import->collection($converted_rows);
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function(AfterImport $event) {
                if ($this->file_pembayaran_path) {
                    Log::info("Semua chunk faktur selesai diproses, memulai import pembayaran...");
                    $this->processPembayaran();
                }
            },
        ];
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

        // Replace comma with dot (decimal separator)
        $value = str_replace(',', '.', $value);

        // Convert to float
        return (float) $value;
    }
}
