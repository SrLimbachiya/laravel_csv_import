<?php
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ModelFactory extends Command
{
    protected $signature = 'generate:models';

    protected $description = 'Generate models for all tables in the database';

    public function handle()
    {
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

        foreach ($tables as $table) {
            $modelName = Str::studly(Str::singular($table));
            $this->call('make:model', [
                'name' => $modelName,
                '--all' => true,
            ]);
        }

        $this->info('Models generated successfully.');
    }
}
