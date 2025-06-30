<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->randomElement([1, 2, 3, 4, 5]),
            'order_id' => fake()->numberBetween(1, 20),
            'transaction_reference' => fake()->word(),
            'amount' => fake()->randomFloat(2, 10, 650),
            'status' => fake()->randomElement(['pending', 'succesfull', 'failed', 'cancelled']),
            'payment_method' => fake()->randomElement(['card', 'transfer', 'crypto'])
        ];
    }
}
