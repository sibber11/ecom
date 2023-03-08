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
        return $this->afterCreating(function (Category $category){
            $image_names = glob('storage/temp/category/*.jpg');
            $random = random_int(0, count($image_names) - 1);
            $category->addMedia($image_names[$random])->preservingOriginal()->toMediaCollection('category_images');
        })->afterMaking(function (Category $category){
            $category->parent_id = Category::inRandomOrder()->first()->id ?? null;
        });
    }

}
