<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name
        ];
    }

    //after creating the model associate to a random parent
    public function configure()
    {
        return $this->afterMaking(function ($category){
            $category->parent_id = Category::inRandomOrder()->first()->id ?? null;
        });
    }

}
