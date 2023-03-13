<?php

namespace App\Models;

use App\Helper\QRCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'created_at' => 'datetime:Y-m-d',
    ];
    protected $attributes = [
        'status' => 'pending',
        'shipping' => 0.00,
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
