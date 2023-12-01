<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\SexType;
use App\Enums\StatusType;
use App\Models\User\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Admin',
//                'username' => 'super.user.admin',
            'status' => StatusType::ACTIVE,
            'sex' => SexType::MALE,
            'email' => 'margar.melkonyan@bk.ru',
            'password' =>'margar.melkonyan@bk.ru',
//                'is_active' => 1,
        ])->assignRole('admin');

    }
}
