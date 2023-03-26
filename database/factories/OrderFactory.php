<?php

namespace Database\Factories;

use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        Cart::instance('cart')->destroy();
        for ($i = 1; $i < fake()->numberBetween(2,10); $i++){
            Cart::add($i, fake()->word, fake()->numberBetween(1,10), fake()->numberBetween(100,1000));
        }
        return [
            'user_id' => 1,
            'status' => fake()->randomElement(array_keys(Order::STATUSES)),
            'subtotal' => Cart::subtotalFloat(),
            'tax' => 0,
            'shipping' => 0,
            'discount' => 0,
            'total' => Cart::totalFloat(),
            'products' => Cart::instance('cart')->content(),
            'payment_method' => 'cash',
            'payment_status' => fake()->randomElement(array_keys(Order::PAYMENT_STATUSES)),
            'payment_id' => null,
            'billing_address' => null,
            'shipping_address' => [
                'phone' => fake()->phoneNumber,
                'address' => fake()->address,
                'city' => fake()->city,
                'country' => fake()->country,
                'zip' => fake()->postcode,],
        ];
    }
}
