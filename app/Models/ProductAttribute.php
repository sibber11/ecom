<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    public const TYPES = [
        'text' => 'Text',
        'textarea' => 'Textarea',
        'select' => 'Select',
        'checkbox' => 'Checkbox',
        'radio' => 'Radio',
    ];
    protected $fillable = [
        'name',
        'type',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];
}
