<?php

declare(strict_types=1);

namespace Database\Factories\Event;

use App\Models\Event\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;


    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'start' => '2023-12-16',
            'end' => '2023-12-26',
            'user_id' => 1,
            'color' => '#FF7F00',
        ];
    }
}

