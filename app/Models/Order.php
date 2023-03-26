<?php

namespace App\Models;

use App\Helper\QRCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $user_id
 * @property array $products
 * @property string $total
 * @property string $tax
 * @property string $subtotal
 * @property string $discount
 * @property string $shipping
 * @property string $status
 * @property string $payment_method
 * @property string $payment_status
 * @property string|null $payment_id
 * @property string|null $billing_address
 * @property string $shipping_address
 * @property string|null $qr_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Review|null $review
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBillingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @mixin \Eloquent
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
        'products' => 'array',
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'created_at' => 'datetime:Y-m-d',
    ];
    protected $attributes = [
        'status' => 'pending',
        'shipping' => 0.00,
    ];
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
