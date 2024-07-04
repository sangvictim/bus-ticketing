<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionDetails>
 */
class TransactionDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'passager_name' => fake()->name(),
            'price',
            'armada_code',
            'armada_name',
            'armada_class',
            'seat_number',
        ];
    }
}
