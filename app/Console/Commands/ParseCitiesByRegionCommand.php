<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\ParseCitiesByRegionJob;
use Illuminate\Console\Command;

class ParseCitiesByRegionCommand extends Command
{
    protected $signature = 'parse-cities:run';

    protected $description = 'Command description';

    public function handle(): void
    {
        ParseCitiesByRegionJob::dispatch();
        $this->info("\n\t Job added.");
    }
}
