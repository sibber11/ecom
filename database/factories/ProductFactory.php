<?php

namespace Database\Factories;

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
    public function definition()
    {
        return [
            'name' => fake()->name,
            'sku' => fake()->unique()->text(8),
            'description' => fake()->text(32),
            'price' => fake()->numberBetween(100, 1000),
            'category_id' => \App\Models\Category::factory(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Product $product) {
            $product->attachTags(fake()->words(3));
        });
    }
}
