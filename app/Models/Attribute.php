<?php

namespace App\Models;

use Database\Factories\AttributeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Attribute extends Model
{
    use HasFactory;

    public $timestamps = false;
    public const TYPES = [
        'select' => 'Select',
        'checkbox' => 'Checkbox',
        'radio' => 'Radio',
    ];
    protected $fillable = [
        'name',
        'type',
    ];

    protected $with = [
        'options',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }


    public function syncOptions(array $options)
    {
        $this->options()->delete();
        $this->add_options($options);
    }

    public function add_options(array $options): void
    {
        foreach ($options as $option) {
            $this->options()->create([
                'name' => Str::ucfirst($option['name']),
                'value' => $option['name'],
            ]);
        }
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }
}
