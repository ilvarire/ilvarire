<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            'brief' => fake()->sentence(),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 10, 650),
            'quantity' => fake()->randomNumber(1),
            'weight' => fake()->randomElement(['1kg', '0.9kg', '5kg', '3kg', '1.4kg', '2kg']),
            'dimensions' => fake()->word(),
            'materials' => fake()->word(),
            'category_id' => fake()->randomElement([1, 2, 3, 4])
        ];
    }
}
