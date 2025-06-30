<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductReview>
 */
class ProductReviewFactory extends Factory
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
            'product_id' => fake()->numberBetween(1, 25),
            'rating' => fake()->randomElement([1, 2, 3, 4, 5]),
            'comment' => fake()->sentence()
        ];
    }
}