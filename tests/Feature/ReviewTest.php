<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_review_can_be_seeded()
    {
        $this->signIn();
        $product = Product::factory()->hasReviews(10)->create();
        $this->assertTrue(true);

    }

    /**
     * @throws \JsonException
     */
    public function test_review_can_be_posted_by_user()
    {
        $this->signIn();
        $product = Product::factory()->create();
        $response = $this->get(route('products.show', $product));
        $response = $this->post(route('review.store'), [
            'body' => 'Test Review Body',
            'rating' => 3,
            'product_id' => $product->id
        ]);

        $response->assertRedirect(route('products.show', $product));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseCount(Review::class, 1);
    }
}
