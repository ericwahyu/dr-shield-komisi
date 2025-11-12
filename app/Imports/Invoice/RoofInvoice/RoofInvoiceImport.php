<?php

namespace App\Imports\Invoice\RoofInvoice;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Throwable;

class RoofInvoiceImport implements WithMultipleSheets, WithChunkReading, ShouldQueue
{
    /**
     * @param Collection $collection
     */
    public function sheets(): array
    {
        // Set limits untuk file besar
        ini_set('max_execution_time', '600'); // 10 menit
        ini_set('memory_limit', '512M');
        set_time_limit(600);

        Log::info('Memulai proses import sheets');

        try {
            return [
                'faktur'     => new RoofInvoiceExecutionImport(),
                'pembayaran' => new RoofInvoiceDetailExecutionImport(),
            ];
        } catch (Exception | Throwable $th) {
            Log::error('Error di sheets Atap(): ' . $th->getMessage());
            return [];
        }
    }

    /**
     * Chunk reading untuk menghemat memory
     */
    public function chunkSize(): int
    {
        return 50; // Process 50 rows per chunk - balance between speed and memory
    }

    private function ensureQueueWorkerRunning()
    {
        try {
            $status = shell_exec('immortalctl status komisi-queue 2>/dev/null');

            if (strpos($status, 'Down') !== false || empty($status)) {
                shell_exec('immortalctl start komisi-queue 2>/dev/null');
                sleep(2);
                Log::info('Queue worker restarted automatically from RoofInvoice job');
            }
        } catch (Exception $e) {
            Log::warning('Failed to check/start queue worker: ' . $e->getMessage());
        }
    }
}
