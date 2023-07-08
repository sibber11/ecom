<?php

namespace App\Models;

use ArrayAccess;
use Database\Factories\ProductFactory;
use Eloquent;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;
use Spatie\Tags\Tag;

class Product extends Model implements HasMedia, Buyable
{
    use HasFactory, HasSlug, HasTags, InteractsWithMedia;

    protected $with = ['brand', 'category', 'media'];
    protected $withCount = ['reviews'];

    protected $fillable = [
        'name',
        'sku',
        'description',
        'category_id',
        'price',
        'old_price',
        'quantity',
        'brand_id',
    ];

    public const MEDIA_COLLECTION = 'product';

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** relations */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function latestReviews(): HasMany
    {
        return $this->reviews()->whereNotNull('body')->latest()->take(3);
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class);
    }


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['name'])
            ->saveSlugsTo('slug');
    }
    /**
     * Get the identifier of the Buyable item.
     */
    public function getBuyableIdentifier($options = null): int|string
    {
        return $this->slug;
    }

    /**
     * Get the description or title of the Buyable item.
     */
    public function getBuyableDescription($options = null): string
    {
        return $this->name;
    }

    /**
     * Get the price of the Buyable item.
     */
    public function getBuyablePrice($options = null): float|int
    {
        return $this->price;
    }

    /**
     * Get the weight of the Buyable item.
     */
    public function getBuyableWeight($options = null): float|int
    {
        return 0;
    }

    public function syncAttributes(array $attributes)
    {
        $this->attributes()->sync($attributes);
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(Click::class);
    }

    public function similarProducts(int $limit = 4): array|Collection
    {
        return Product::withAnyTags($this->tags)
            ->where('id', '!=', $this->id)
            ->take($limit)
            ->withAvg('reviews', 'rating')
            ->get();
    }

    public function order()
    {
        $this->belongsToMany(Order::class);
    }

    /**
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(100)
            ->height(100)
            ->sharpen(10);
    }

    public function getRatingsAttribute()
    {
        // return count of each rating
        return $this->reviews()
            ->selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating');
    }

    public function getImage(): string
    {
        if ($this->hasMedia(static::MEDIA_COLLECTION))
            return $this->getFirstMediaUrl(Product::MEDIA_COLLECTION);
        else
            return asset('assets/fallback_image.jpg');
    }

}
