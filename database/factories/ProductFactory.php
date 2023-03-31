<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Tags\Tag;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    //list of furniture names
    private array $product_names = [
        'Chair',
        'Table',
        'Couch',
        'Bed',
        'Desk',
        'Cabinet',
        'Bookshelf',
        'Sofa',
        'Dresser',
        'Nightstand',
        'Chest',
        'Wardrobe',
        'Armchair',
        'Stool',
        'Bench',
        'Cupboard',
        'Sideboard',
        'Trunk',
        'Coffee table',
        'Console',
        'Mirror',
        'Lamp',
        'Rug',
        'Pillow',
        'Curtain',
        'Blinds',
        'Vase',
        'Picture',
        'Clock',
        'Bowl',
        'Basket',
        'Towel',
        'Tissue',
        'Soap',
        'Shampoo',
        'Conditioner',
        'Toothbrush',
        'Toothpaste',
        'Deodorant',
        'Shaving',
    ];
    /**
     * Define the model's default state.
     */
    public function definition()
    {
        $category = Category::inRandomOrder()->first() ?? Category::factory();
        $brand = Brand::inRandomOrder()->first() ?? Brand::factory();
        $price = fake()->numberBetween(100, 1000);
        $old_price = $price * 1.2;
        return [
            'name' => fake()->randomElement($this->product_names),
            'sku' => Str::random(8),
            'description' => fake()->text(320),
            'price' => $price,
            'old_price' => $old_price,
            'category_id' => $category,
            'quantity' => fake()->numberBetween(1, 100),
            'brand_id' => $brand,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            if ($product->tags()->count() === 0) {
                $product->attachTags(Tag::inRandomOrder()->take(3)->get());
            }
            $image_names = glob('storage/temp/product/*.jpg');
            if (env('app_env') != 'testing'){
                $random = random_int(0, count($image_names) - 1);
                $product->addMedia($image_names[$random])
                    ->preservingOriginal()
                    ->toMediaCollection(Product::MEDIA_COLLECTION);
            }
        });
    }

    // a function to create a product with tags
    public function withTags($tags)
    {
        return $this->afterCreating(function (Product $product) use ($tags) {
            $product->attachTags($tags);
        });
    }

}
