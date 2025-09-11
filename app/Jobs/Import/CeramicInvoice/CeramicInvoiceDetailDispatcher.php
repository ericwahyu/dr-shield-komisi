<?php

namespace App\Jobs\Import\CeramicInvoice;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CeramicInvoiceDetailDispatcher implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

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
        $chunks = $this->collections->chunk(200);

        foreach ($chunks as $chunk) {
            dispatch(new CeramicInvoiceDetail($chunk));
        }
    }
}
