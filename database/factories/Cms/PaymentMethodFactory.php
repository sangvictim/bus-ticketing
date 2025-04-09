<?php

namespace Database\Factories\Cms;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cms\PaymentMethod>
 */
class PaymentMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'icon' => 'https://placehold.co/600x400',
            'name' => fake()->name(),
            'code' => fake()->name(),
            'country' => 'ID',
            'currency' => 'IDR',
            'isActivated' => true,
        ];
    }
}
