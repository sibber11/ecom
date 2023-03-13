<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function show(Product $product)
    {
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
        $product->append([
            'avg_rating',
            'ratings',
            'rating_count'
        ]);
        return Inertia::render('Customer/Product', [
            'product' => $product,
        ]);
    }
}
