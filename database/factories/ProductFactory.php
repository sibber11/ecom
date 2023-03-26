<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $category = Category::inRandomOrder()->first() ?? Category::factory();
        $brand = Brand::inRandomOrder()->first() ?? Brand::factory();
        $price = fake()->numberBetween(100, 1000);
        $old_price = $price * 1.2;
        return [
            'name' => fake()->word,
            'sku' => Str::random(8),
            'description' => fake()->text(32),
            'price' => $price,
            'old_price' => $old_price,
            'category_id' => $category,
            'quantity' => fake()->numberBetween(1, 100),
            'brand_id' => $brand,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Product $product) {
            if ($product->tags()->count() === 0) {
                $product->attachTags(fake()->words(3));
            }
            $image_names = glob('storage/temp/product/*.jpg');
            $random = random_int(0, count($image_names) - 1);
            $product->addMedia($image_names[$random])
                ->preservingOriginal()
                ->toMediaCollection(Product::MEDIA_COLLECTION);
        });
    }

    // a function to create a product with tags
    public function withTags($tags)
    {
        return $this->afterCreating(function (\App\Models\Product $product) use ($tags) {
            $product->attachTags($tags);
        });
    }

}
