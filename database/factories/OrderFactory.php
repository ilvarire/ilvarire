<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\ShippingAddress;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
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
            'total_price' => fake()->randomFloat(2, 10, 650),
            'status' => fake()->randomElement(['pending', 'processed', 'shipped', 'delivered', 'cancelled']),
            'payment_id' => Payment::factory(),
            'shipping_address_id' => ShippingAddress::factory(),
            'coupon_id' => fake()->randomElement([1, 2])
        ];
    }
}
