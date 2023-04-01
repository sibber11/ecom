<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;


/**
 * App\Models\Click
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $product_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Product $product
 * @property-read User|null $user
 * @method static Builder|Click newModelQuery()
 * @method static Builder|Click newQuery()
 * @method static Builder|Click query()
 * @method static Builder|Click whereCreatedAt($value)
 * @method static Builder|Click whereId($value)
 * @method static Builder|Click whereProductId($value)
 * @method static Builder|Click whereUpdatedAt($value)
 * @method static Builder|Click whereUserId($value)
 * @mixin Eloquent
 */
class Click extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
