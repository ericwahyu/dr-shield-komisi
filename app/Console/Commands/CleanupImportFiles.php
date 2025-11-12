<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class CleanupImportFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'imports:cleanup {--days=7 : Delete files older than this many days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old import files from storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        $path = storage_path('app/imports/roof-invoice');

        if (!File::exists($path)) {
            $this->warn("Import directory does not exist: {$path}");
            return;
        }

        $files = File::files($path);
        $deleted = 0;
        $totalSize = 0;

        $this->info("Scanning import files...");
        $this->info("Delete files older than {$days} days");

        foreach ($files as $file) {
            $lastModified = Carbon::createFromTimestamp($file->getMTime());
            $age = now()->diffInDays($lastModified);

            if ($age > $days) {
                $size = $file->getSize();
                $totalSize += $size;

                $this->line("Deleting: {$file->getFilename()} (age: {$age} days, size: " . $this->formatBytes($size) . ")");

                unlink($file->getPathname());
                $deleted++;
            }
        }

        if ($deleted > 0) {
            $this->info("\n✓ Deleted {$deleted} files");
            $this->info("✓ Freed " . $this->formatBytes($totalSize) . " storage");
        } else {
            $this->info("\n✓ No files to delete");
        }
    }

    /**
     * Format bytes to human readable
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
