<?php

namespace App\Imports\Invoice\RoofInvoice;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Throwable;

class RoofInvoiceImport implements WithMultipleSheets
{
    /**
     * @param Collection $collection
     */
    public function sheets(): array
    {
        Log::info('Memulai proses import sheets');

        try {
            $this->ensureQueueWorkerRunning();

            return [
                'faktur'     => new RoofInvoiceExecutionImport(),
                'pembayaran' => new RoofInvoiceDetailExecutionImport(),
            ];
        } catch (Exception | Throwable $th) {
            Log::error('Error di sheets Atap(): ' . $th->getMessage());
            return [];
        }
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
