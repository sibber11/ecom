<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'body' => fake()->text,
            'rating' => fake()->numberBetween(1, 5),
            'product_id' => fake()->numberBetween(1, 10),
            'user_id' => 1,
            'created_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
