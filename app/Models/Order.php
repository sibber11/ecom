<?php

namespace App\Models;

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
    ];
    protected $casts = [
        'products' => 'array',
    ];
    protected $attributes = [
        'status' => 'pending',
        'shipping' => 0.00,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
