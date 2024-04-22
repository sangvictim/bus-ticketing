<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Price>
 */
class PriceFactory extends Factory
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
            'class_id' => fake()->numberBetween(1, 10),
            'name' => fake()->name(),
            'price' => fake()->numberBetween(100000, 1000000),
            'cut_of_price' => fake()->numberBetween(100000, 1000000),
            'discount' => fake()->numberBetween(10000, 100000),
            'discount_type' => fake()->randomElement(['percentage', 'amount']),
        ];
    }
}
