<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShippingAddress>
 */
class ShippingAddressFactory extends Factory
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
            'country_id' => fake()->randomElement([1, 2, 3, 4]),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'state' => fake()->word(),
            'zip_code' => fake()->postcode()
        ];
    }
}
