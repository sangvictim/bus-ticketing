<?php

namespace Database\Factories\Cms;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cms\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'route_id' => fake()->numberBetween(1, 10),
            'buses_id' => fake()->numberBetween(1, 10),
            'departure_time' => fake()->time(),
            'arrival_time' => fake()->time(),
        ];
    }
}
