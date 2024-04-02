<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Destination>
 */
class DestinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'city_id' => 1,
            'district_id' => 2,
            'address' => fake()->name(),
            'description' => fake()->name(),
            'telp' => fake()->name(),
            'isActive' => 1
        ];
    }
}
