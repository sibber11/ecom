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
 * @property int $stock
 * @property int $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Attribute> $attributes
 * @property-read int|null $attributes_count
 * @property-read Brand|null $brand
 * @property-read Category|null $category
 * @property-read Collection<int, Click> $clicks
 * @property-read int|null $clicks_count
 * @property-read Collection<int, Review> $latestReviews
 * @property-read int|null $latest_reviews_count
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Collection<int, Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read int|null $reviews_avg_rating
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
 * @method static Builder|Product whereIsActive($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product whereOldPrice($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereQuantity($value)
 * @method static Builder|Product whereSku($value)
 * @method static Builder|Product whereSlug($value)
 * @method static Builder|Product whereStock($value)
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

}
