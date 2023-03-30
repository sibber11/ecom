<?php

namespace App\Models;

use Database\Factories\AttributeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProductAttribute
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property array|null $options
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static AttributeFactory factory($count = null, $state = [])
 * @method static Builder|Attribute newModelQuery()
 * @method static Builder|Attribute newQuery()
 * @method static Builder|Attribute query()
 * @method static Builder|Attribute whereCreatedAt($value)
 * @method static Builder|Attribute whereId($value)
 * @method static Builder|Attribute whereName($value)
 * @method static Builder|Attribute whereOptions($value)
 * @method static Builder|Attribute whereType($value)
 * @method static Builder|Attribute whereUpdatedAt($value)
 * @mixin Eloquent
 */
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
        return $this->belongsToMany(Product::class, 'product_attributes');
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }
}
