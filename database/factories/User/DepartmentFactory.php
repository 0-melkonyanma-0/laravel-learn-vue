<?php

declare(strict_types=1);

namespace Database\Factories\User;

use App\Models\User\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    protected $model = Department::class;


    public function definition(): array
    {
        return [
            'title' => $this->faker->word()
        ];
    }
}
