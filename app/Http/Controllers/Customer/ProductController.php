<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
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
        }else{
            $product->load('latestReviews.user:id,name');
        }
        return Inertia::render('Customer/Product', [
            'product' => $product,
        ]);
    }
}
