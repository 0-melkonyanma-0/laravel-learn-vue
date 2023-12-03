<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunFreshMigrationSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed-fresh:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Wipe db and migrate with seed all need data for project.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('migrate:fresh');
        $this->info("\n\t DB now clean.");
        $this->info("\n\t Run migrations started.");
        Artisan::call('db:seed --class=RolePermissionsSeeder');
        Artisan::call('db:seed --class=SuperUserSeeder');
        Artisan::call('db:seed');
        $this->info("\n\t All data was seeded.");
    }
}
