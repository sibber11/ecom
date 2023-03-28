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
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;
use Spatie\Tags\Tag;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $sku
 * @property string $description
 * @property int $price
 * @property int $old_price
 * @property int $quantity
 * @property int $category_id
 * @property int $brand_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Brand|null $brand
 * @property-read Category|null $category
 * @property-read mixed $avg_rating
 * @property-read mixed $rating_count
 * @property-read mixed $ratings
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Collection<int, Review> $reviews
 * @property-read int|null $reviews_count
 * @property Collection<int, Tag> $tags
 * @property-read int|null $tags_count
 * @method static ProductFactory factory($count = null, $state = [])
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereBrandId($value)
 * @method static Builder|Product whereCategoryId($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product whereOldPrice($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereQuantity($value)
 * @method static Builder|Product whereSku($value)
 * @method static Builder|Product whereSlug($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product withAllTags(ArrayAccess|Tag|array|string $tags, ?string $type = null)
 * @method static Builder|Product withAllTagsOfAnyType($tags)
 * @method static Builder|Product withAnyTags(ArrayAccess|Tag|array|string $tags, ?string $type = null)
 * @method static Builder|Product withAnyTagsOfAnyType($tags)
 * @method static Builder|Product withoutTags(ArrayAccess|Tag|array|string $tags, ?string $type = null)
 * @mixin Eloquent
 */
class Product extends Model implements HasMedia, Buyable
{
    use HasFactory, HasSlug, HasTags, InteractsWithMedia;

    protected $with = ['brand', 'category', 'media'];

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

    protected $appends = [
//        'avg_rating',
//        'ratings',
//        'rating_count',
    ];
    public const MEDIA_COLLECTION = 'product';

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['name'])
            ->saveSlugsTo('slug');
    }
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the identifier of the Buyable item.
     *
     * @return int|string
     */
    public function getBuyableIdentifier($options = null): int|string
    {
        return $this->slug;
    }

    /**
     * Get the description or title of the Buyable item.
     *
     * @return string
     */
    public function getBuyableDescription($options = null): string
    {
        return $this->name;
    }

    /**
     * Get the price of the Buyable item.
     *
     * @return float
     */
    public function getBuyablePrice($options = null): float|int
    {
        return $this->price;
    }

    /**
     * Get the weight of the Buyable item.
     *
     * @return float
     */
    public function getBuyableWeight($options = null): float|int
    {
        return 0;
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }


    public function getRatingsAttribute(): array
    {
        return $this->reviews()->selectRaw('rating, count(*) as rating_count')->groupBy('rating')->get()->pluck('rating_count', 'rating')->toArray();
    }
    public function getAvgRatingAttribute(): float
    {
        //return avg rating upto 1 decimal place
        return round($this->reviews->avg('rating'), 1);

    }

    public function getRatingCountAttribute(): int
    {
        return $this->reviews->count();
    }

    public function latestReviews(): HasMany
    {
        return $this->reviews()->whereNotNull('body')->latest()->take(3);
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class);
    }

    public function syncAttributes(array $attributes)
    {
        $this->attributes()->sync($attributes);
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(Click::class);
    }
}
