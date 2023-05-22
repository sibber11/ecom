<?php

namespace App\Http\Controllers\Customer;

use App\Events\ProductViewed;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductForCardResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function show(Product $product): Response
    {
        ProductViewed::dispatch($product);
        //validate the request
        request()->validate([
            'reviews' => 'nullable|integer|min:3'
        ]);

        // check if the user is requesting for more reviews.
        if (request()->has('reviews')) {
            $product->load(['latestReviews' => function ($query) {
                $query->with('user:id,name')->take(request()->get('reviews'));
            }]);
        } else {
            $product->load('latestReviews.user:id,name');
        }
        // loading the all the attributes and average rating on the reviews table.
        $product
            ->load('attributes')
            ->loadAvg('reviews', 'rating')
            ->append('ratings');
        // get some similar products
        $similar_products = ProductForCardResource::collection($product->similarProducts());
        return Inertia::render('Customer/Product', [
            'product' => new ProductResource($product),
            'relatedProducts' => $similar_products,
        ]);
    }
}
