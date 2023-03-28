<?php

namespace Tests\Feature;

use App\Models\Click;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClickTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_click_can_be_registered_without_login()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.show', $product));

        $response->assertOk();
        $this->assertDatabaseCount(Click::class, 1);
    }

    public function test_click_can_be_registered_with_login()
    {
        $this->signIn();
        $product = Product::factory()->create();

        $response = $this->get(route('products.show', $product));

        $response->assertOk();
        $this->assertDatabaseCount(Click::class, 1);
    }
}
