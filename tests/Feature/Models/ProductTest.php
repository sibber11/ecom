<?php

namespace Tests\Feature\Models;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_product_screen_can_be_rendered()
    {
        $this->signIn();
        $response = $this->get(route('admin.products.create'));

        $response->assertStatus(200);
    }

    public function test_product_factory_can_be_used()
    {
        $this->withoutExceptionHandling();
        Product::factory()->create();
        $this->assertDatabaseCount(Product::class, 1);
    }
}

