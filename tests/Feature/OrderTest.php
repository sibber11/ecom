<?php

namespace Tests\Feature;

use App\Models\Order;
use Database\Factories\OrderFactory;
use Database\Seeders\OrderSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
            'products' => [
                [
                    'id' => 1,
                    'name' => 'Product 1',
                    'price' => 100,
                    'quantity' => 1,
                ]
            ]
        ]);
        $this->assertDatabaseHas('orders', [
            'user_id' => 1,
            'status' => 'pending',
            'subtotal' => 100,
            'tax' => 0,
            'shipping' => 0,
            'discount' => 0,
            'total' => 100,
            'products' => json_encode([
                [
                    'id' => 1,
                    'name' => 'Product 1',
                    'price' => 100,
                    'quantity' => 1,
                ]
            ])
        ]);
    }
}
