<?php

namespace Database\Factories;

use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAttribute>
 */
class ProductAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $options = fake()->words(fake()->numberBetween(2, 5));
        //map the array to an array of key value pairs with unique index and name keys
        $options = array_map(function ($option, $index) {
            return [
                'index' => $index,
                'name' => $option,
            ];
        }, $options, range(0, count($options) - 1));
        return [
            'name' => fake()->name,
            'type' => fake()->randomElement(array_keys(ProductAttribute::TYPES)),
            'options' => $options,
        ];
    }
}
