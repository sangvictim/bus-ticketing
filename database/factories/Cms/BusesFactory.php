<?php

namespace Database\Factories\Cms;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cms\Buses>
 */
class BusesFactory extends Factory
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
            'code' => fake()->randomNumber(3),
            'manufacturer' => fake()->randomElement(['Mercedes Benz OH 1626', 'HINO RM 280 ABS', 'Scania K410 IB']),
            'production_year' => fake()->randomElement(['2023', '2022', '2021', '2020', '2019']),
            'capacity' => 40,
            'status' => 'ACTIVE',
        ];
    }
}
