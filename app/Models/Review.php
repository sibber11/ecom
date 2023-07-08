<?php

namespace App\Models;

use Database\Factories\ReviewFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'body',
        'rating',
        'product_id',
        'user_id',
        'order_id',
    ];

    protected $attributes = [
        'order_id' => '0',
    ];
    protected $casts = [
        'order_id' => 'integer',
        'created_at' => 'datetime:d M y',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
