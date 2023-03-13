<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'status' => fake()->randomElement(Order::STATUSES),
            'subtotal' => fake()->numberBetween(100, 1000),
            'tax' => 0,
            'shipping' => 0,
            'discount' => 0,
            'total' => fake()->numberBetween(100, 1000),
            'products' => [

            ],
            'payment_method' => 'cash',
            'payment_status' => fake()->randomElement(['paid', 'unpaid']),
            'payment_id' => null,
            'billing_address' => null,
            'shipping_address' => fake()->address,
        ];
    }
}
