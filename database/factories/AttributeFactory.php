<?php

namespace Database\Factories;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attribute>
 */
class AttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    private $attribute_names = [
        'color',
        'size',
        'material',
        'weight',
    ];
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
            'name' => fake()->unique()->randomElement($this->attribute_names),
            'type' => fake()->randomElement(array_keys(Attribute::TYPES)),
            'options' => $options,
        ];
    }
}
