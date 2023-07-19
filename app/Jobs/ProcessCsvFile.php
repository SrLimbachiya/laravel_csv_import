<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessCsvFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        // Read and process the CSV file
        $file = fopen($this->filePath, 'r');
        while (($data = fgetcsv($file)) !== false) {
            // Process each row of data
            // ...
        }
        fclose($file);

        // Clean up the processed file if needed
        Storage::delete($this->filePath);
    }
}
