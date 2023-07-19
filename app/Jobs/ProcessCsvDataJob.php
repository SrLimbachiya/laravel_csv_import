<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessCsvDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    public function handle()
    {
        $file = Storage::disk('temp')->path($this->fileName);

        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                // Process each row of CSV data here
                // ...

                // For example, you can insert the data into the database:
                // YourModel::create(['column_name' => $data[0], 'column_name' => $data[1], ...]);
            }
            fclose($handle);
        }

        // Once the processing is complete, you can remove the temporary file
        Storage::disk('temp')->delete($this->fileName);
    }
}
