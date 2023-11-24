<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User\Department;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Department::factory(100)->create();
    }
}
