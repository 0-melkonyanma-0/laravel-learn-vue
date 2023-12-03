<?php

declare(strict_types=1);

namespace App\Console;

use App\Jobs\ParseCitiesByRegionJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new ParseCitiesByRegionJob())->daily();
    }


    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
