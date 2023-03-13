<?php

namespace Database\Factories;

use App\Helper\QRCode;
use Illuminate\Database\Eloquent\Factories\Factory;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'status' => 'pending',
            'subtotal' => fake()->numberBetween(100, 1000),
            'tax' => 0,
            'shipping' => 0,
            'discount' => 0,
            'total' => fake()->numberBetween(100, 1000),
            'products' => [

            ],
            'payment_method' => 'cash',
            'payment_status' => 'pending',
            'payment_id' => null,
            'billing_address' => null,
            'shipping_address' => fake()->address,
        ];
    }
}
