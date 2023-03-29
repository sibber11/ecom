<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

class TagSeeder extends Seeder
{
    private array $product_tags = [
        'men',
        'women',
        'kids',
        'shoes',
        'clothes',
        'accessories',
        'bags',
        'jewelry',
        'watches',
        'electronics',
        'home',
        'beauty',
        'sports',
        'outdoors',
        'toys',
        'games',
        'books',
        'music',
        'movies',
        'office',
        'garden',
        'tools',
        'automotive',
        'industrial',
        'grocery',
        'pets',
        'health',
        'personal',
        'baby',
        'luggage',
        'furniture',
        'appliances',
        'arts',
        'crafts',
        'collectibles',
        'patio',
        'hobbies',
        'diy',
        'party',
        'wedding',
        'holiday',
        'gifts',
        'handmade',
        'services',
        'other',
        'new',
    ];
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach ($this->product_tags as $tag) {
            Tag::create(['name' => $tag]);
        }
    }
}
