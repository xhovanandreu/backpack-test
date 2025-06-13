<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\ArticlesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class ImportArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     *  The "path" argument is a required argument that represents a system path.
     *
     *  Example usage:
     *  php artisan app:import-articles /home/user/Downloads/test.csv
     *
     * @var string
     */
    protected $signature = 'app:import-articles
        {filePath : Path represents a system path of the file to be imported}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import articles from a CSV file to database';

    /**
     * Execute the console command.
     *
     * @param ArticlesImport $articlesImport
     */
    public function handle(ArticlesImport $articlesImport):void
    {
        try {
            Excel::import($articlesImport, $this->argument('filePath'));
            $this->info('The articles imported successfully!');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            Log::error($e->getMessage());

            $failures = $e->failures();

            foreach ($failures as $failure) {
                Log::error("Row {$failure->row()}: " . implode(', ', $failure->errors()));
            }

            $this->error('The command failed! Take a look on logs.');
        }
    }






}
