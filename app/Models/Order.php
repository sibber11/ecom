<?php

namespace App\Models;

use App\Events\OrderCancelled;
use App\Events\OrderDelivered;
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
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price', 'total', 'options');
    }

    public function addProducts(Collection $content)
    {
        $products = Product::whereIn('slug', $content->pluck('id'))->get();
        $content->each(function ($item) use ($products) {
            $product_id = $products->where('slug', $item->id)->first()->id;
            $this->products()->attach($product_id, ['quantity' => $item->qty, 'price' => $item->price, 'total' => $item->total, 'options' => $item->options]);
        });
    }

    public function cancel()
    {
        // check if the order is cancellable
        if ($this->isCancellable()){
            // set the status of the order to cancelled
            // dispatch the OrderCancelled event
            $this->changeStatus('cancelled');
            OrderCancelled::dispatch();
        }
    }

    public function complete()
    {
        if ($this->isCompletable()){
            $this->changeStatus('completed');
            OrderDelivered::dispatch();
        }
    }

    public function changeStatus($status)
    {
        $this->status = $status;
        $this->save();
    }

    public function isCancellable(): bool
    {
        return true;
    }

    private function isCompletable(): bool
    {
        return true;
    }

}
