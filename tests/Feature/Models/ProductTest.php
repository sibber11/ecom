<?php

namespace Tests\Feature\Models;

use App\Http\Resources\ProductForCardResource;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;
use function PHPUnit\Framework\assertCount;

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

    public function test_product_can_be_serialized()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $product = Product::factory()->hasReviews(3)->create();
        self::assertCount(3, $product->reviews);
        assertCount(1, $product->media);
        $resource = ProductForCardResource::make($product);
        $this->assertNotNull($resource);
    }
}

