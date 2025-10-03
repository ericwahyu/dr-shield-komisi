<?php

namespace App\Imports\Invoice\CeramicInvoice;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Throwable;

class CeramicInvoiceImport implements WithMultipleSheets
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
                'faktur'     => new CeramicInvoiceExecutionImport(),
                'pembayaran' => new CeramicInvoiceDetailExecutionImport(),
            ];
        } catch (Exception | Throwable $th) {
            Log::error('Error di sheets Keramik(): ' . $th->getMessage());
            return [];
        }
    }
    
    private function ensureQueueWorkerRunning()
    {
        try {
            $status = shell_exec('immortalctl status queue 2>/dev/null');
            
            if (strpos($status, 'Down') !== false || empty($status)) {
                shell_exec('immortalctl start queue 2>/dev/null');
                sleep(2);
                Log::info('Queue worker restarted automatically from CeramicInvoice job');
            }
        } catch (Exception $e) {
            Log::warning('Failed to check/start queue worker: ' . $e->getMessage());
        }
    }
}
