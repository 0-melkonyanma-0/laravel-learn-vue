<?php

declare(strict_types=1);

namespace Database\Factories\Event;

use App\Models\Event\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;


    public function definition(): array
    {
        $number = rand(0, 365);

        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'start' => Carbon::today(),
            'end' => Carbon::today()->addDays($number),
            'user_id' => 1,
            'status' => true,
            'color' => '#FF7F00',
            'updated_at' => Carbon::today()->addDays($number),
        ];
    }
}

