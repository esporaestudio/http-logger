<?php

namespace Espora\HttpLogger\Commands;

use Illuminate\Console\Command;

use Espora\HttpLogger\Models\HttpLog;

class PurgeCommand extends Command
{
    public $signature = 'espora:http-logger:purge {--force}';

    public $description = 'Purge the http logs table';

    public function handle()
    {
        $force = $this->option('force');
        if ($force || $this->confirm('Are you sure you want to delete the logs?')) {
            HttpLog::truncate();
            $this->comment('Everything was deleted');
        } else {
            $this->comment('Nothing was deleted');
        }
    }
}
