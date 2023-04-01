<?php

namespace App\Http\Controllers\Customer;

use App\Events\ProductViewed;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductForCardResource;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function show(Product $product): Response
    {
        ProductViewed::dispatch($product);
        request()->validate([
            'reviews' => 'integer|min:3'
        ]);
        if (request()->has('reviews')) {
            $product->load(['latestReviews' => function ($query) {
                $query->with('user:id,name')->take(request()->get('reviews'));
            }]);
        } else {
            $product->load('latestReviews.user:id,name');
        }
        $product->load('attributes')->loadAvg('reviews', 'rating');
        $similar_products = ProductForCardResource::collection($product->similarProducts());
        return Inertia::render('Customer/Product', [
            'product' => $product,
            'relatedProducts' => $similar_products,
        ]);
    }
}
