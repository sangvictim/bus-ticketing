<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "qty_passanger" => 1,
            "total_amount" => 600000,
            "origin_city" => 42,
            "destination_city" => 57,
            "status" => "BOOKED"
        ];
    }
}
