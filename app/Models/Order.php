<?php

namespace App\Models;

use App\Helper\QRCode;
use Database\Factories\OrderFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;


/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $user_id
 * @property string $total
 * @property string $tax
 * @property string $subtotal
 * @property string $discount
 * @property string $shipping
 * @property string $status
 * @property string $payment_method
 * @property string $payment_status
 * @property string|null $payment_id
 * @property array|null $billing_address
 * @property array $shipping_address
 * @property string|null $qr_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Product> $products
 * @property-read int|null $products_count
 * @property-read Review|null $review
 * @property-read User $user
 * @method static OrderFactory factory($count = null, $state = [])
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereBillingAddress($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereDiscount($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order wherePaymentId($value)
 * @method static Builder|Order wherePaymentMethod($value)
 * @method static Builder|Order wherePaymentStatus($value)
 * @method static Builder|Order whereQrCode($value)
 * @method static Builder|Order whereShipping($value)
 * @method static Builder|Order whereShippingAddress($value)
 * @method static Builder|Order whereStatus($value)
 * @method static Builder|Order whereSubtotal($value)
 * @method static Builder|Order whereTax($value)
 * @method static Builder|Order whereTotal($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereUserId($value)
 * @mixin Eloquent
 */
class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'products',
        'total',
        'tax',
        'subtotal',
        'discount',
        'shipping',
        'status',
        'payment_method',
        'payment_status',
        'payment_id',
        'billing_address',
        'shipping_address',
    ];
    protected $casts = [
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'created_at' => 'datetime:Y-m-d',
    ];
    protected $attributes = [
        'status' => 'pending',
        'shipping' => 0.00,
    ];
    protected $with = ['products'];
    public const STATUSES = [
        'pending' => 'Pending',
        'confirmed' => 'Confirmed',
        'processing' => 'Processing',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    public const PAYMENT_METHODS = [
        'cash' => 'Cash',
        'card' => 'Card',
        'paypal' => 'Paypal',
        'stripe' => 'Stripe',
    ];

    public const PAYMENT_STATUSES = [
        'paid' => 'Paid',
        'unpaid' => 'Unpaid',
    ];

    //when order is created generate qr code
    protected static function boot()
    {
        parent::boot();
        static::created(function ($order) {
            $order->update([
                'qr_code' => QRCode::generate($order->id),
            ]);
        });
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
    public function addProducts(Collection $content)
    {
        $products = Product::whereIn('slug', $content->pluck('id'))->get();
        $content->each(function ($item) use ($products) {
            $product_id = $products->where('slug', $item->id)->first()->id;
            $this->products()->attach($product_id, ['quantity' => $item->qty, 'price' => $item->price, 'total' => $item->total, 'options' => $item->options]);
        });
    }
}
