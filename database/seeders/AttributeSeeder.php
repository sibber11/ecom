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
            'small',
            'medium',
            'large',
            'extra large',
            'extra extra large',
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
            $options = array_map(function ($option, $index) {
                return [
                    'index' => $index,
                    'name' => $option,
                ];
            }, $options, range(0, count($options) - 1));
            $attribute = Attribute::factory()->create([
                'name' => $name,
                'options' => $options,
            ]);

        }
    }
}
