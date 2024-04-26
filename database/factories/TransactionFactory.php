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
            "total_price" => 300000,
            "price" => 300000,
            "origin_city" => 42,
            "destination_city" => 57,
            "armada_code" => 123,
            "armada_name" => "kuda bringas",
            "armada_class" => "executive",
            "armada_seat" => "1A"
        ];
    }
}
