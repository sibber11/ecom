<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{

    private $attributes = [
        'color' => [
            'red',
            'blue',
            'green',
            'yellow',
            'orange',
            'purple',
            'black',
            'white',
            'grey',
            'brown',
            'pink',
            'gold',
            'silver',
        ],
        'size' => [
            'XS',
            'S',
            'M',
            'L',
            'XL',
        ],
        'material' => [
            'cotton',
            'wool',
            'polyester',
            'leather',
            'suede',
            'denim',
            'linen',
            'silk',
            'cashmere',
            'rayon',
            'spandex',
            'nylon',
            'velvet',
            'lace',
            'fur',
            'satin',
            'tweed',
            'jersey',
            'chiffon',
            'flannel',
            'corduroy',
            'tulle',
            'knit',
            'suede',
            'twill',
            'poplin',
            'crepe',
            'velour',
            'fleece',
            'lace',
            'satin',
            'tweed',
            'jersey',
            'chiffon',
            'flannel',
            'corduroy',
            'tulle',
            'knit',
            'suede',
            'twill',
            'poplin',
            'crepe',
            'velour',
            'fleece',
        ],
        'weight' => [
            'light',
            'medium',
            'heavy',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach ($this->attributes as $name => $options) {
            $attribute = Attribute::create([
                'name' => $name,
                'type' => 'select',
            ]);
            $attribute->options()->createMany(
                collect($options)->map(fn ($option) => ['name' => $option, 'value' => $option])->toArray()
            );
        }
    }
}
