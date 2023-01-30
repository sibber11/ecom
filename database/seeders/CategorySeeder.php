<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private array $categories =
        array(
            'Clothing' => array(
                'Men\'s Clothing',
                'Women\'s Clothing',
                'Children\'s Clothing',
                'Accessories'
            ),
            'Electronics' => array(
                'Computers',
                'Smartphones',
                'Televisions',
                'Home Theater Systems'
            ),
            'Home and Garden' => array(
                'Furniture',
                'Appliances',
                'Outdoor Equipment',
                'Decor'
            ),
            'Beauty and Personal Care' => array(
                'Makeup',
                'Skin Care',
                'Hair Care',
                'Fragrances'
            ),
            'Toys and Games' => array(
                'Action Figures',
                'Board Games',
                'Dolls',
                'Outdoor Play Equipment'
            ),
            'Sports and Outdoors' => array(
                'Sporting Goods',
                'Outdoor Gear',
                'Fitness Equipment'
            ),
            'Books' => array(
                'Fiction',
                'Non-Fiction',
                'Children\'s Books',
                'Textbooks'
            ),
            'Music' => array(
                'CDs',
                'Vinyl Records',
                'Digital Downloads'
            ),
            'Movies and TV' => array(
                'Blu-rays',
                'DVDs',
                'Digital Downloads'
            ),
            'Food and Beverages' => array(
                'Grocery',
                'Alcohol',
                'Specialty Foods'
            )
        );

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        foreach ($this->categories as $category => $subcategories) {
            $parent = Category::create([
                'name' => $category
            ]);
            $image_names = glob('storage/temp/category/*.jpg');
            $random = random_int(0, count($image_names) - 1);
            $parent->addMedia($image_names[$random])->preservingOriginal()->toMediaCollection('category_images');

            foreach ($subcategories as $subcategory) {
                Category::create([
                    'name' => $subcategory,
                    'parent_id' => $parent->id
                ]);
            }
        }
    }
}
