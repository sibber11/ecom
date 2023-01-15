<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model implements HasMedia
{
    use HasFactory, NodeTrait, HasSlug, InteractsWithMedia;

    public $timestamps = false;
    protected $fillable = [
        'name'
    ];
    protected $appends = [
        'parent_name'
    ];

    protected $with = ['media'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getParentNameAttribute()
    {
        return $this->parent?->name;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
