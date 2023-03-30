<?php

namespace Models;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_order_can_be_seeded()
    {
        $this->signIn();
        Order::factory()->create([
            'user_id' => 1,
            'status' => 'pending',
            'subtotal' => 100,
            'tax' => 0,
            'shipping' => 0,
            'discount' => 0,
            'total' => 100,
        ]);
        $this->assertDatabaseHas('orders', [
            'user_id' => 1,
            'status' => 'pending',
            'subtotal' => 100,
            'tax' => 0,
            'shipping' => 0,
            'discount' => 0,
            'total' => 100,
        ]);
    }

    public function test_order_can_be_placed()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $product = Product::factory()->create();

        $response = $this->post(route('cart.store', $product),[
            'quantity' => 1,
            'options' => [
                'size' => 'large',
                'color' => 'red',
            ]
        ]);
        $response->assertRedirect();

        $response = $this->post(route('checkout.store'), [
            'payment_method' => 'cash',
            'address' => "Address",
            'city' => "City",
            'state' => "State",
            'country' => "Country",
            'zip' => "Zip",
            'phone' => "Phone",
            'email' => "Email",
            'notes' => "Notes",
            'terms' => 'on',
            ]);
        $response->assertRedirect();
    }
}
