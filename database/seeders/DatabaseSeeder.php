<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\User;
use App\Models\User\JobTitle;
use PharIo\Version\Exception;
use App\Models\User\Department;
use Illuminate\Database\Seeder;
use Doctrine\DBAL\Query\QueryException;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1000)->create();
        // Department::factory(20)->create();
        // JobTitle::factory(20)->create();
    }
}
