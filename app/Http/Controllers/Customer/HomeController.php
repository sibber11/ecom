<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductForCardResource;
use App\Models\Product;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $newArrival = ProductForCardResource::collection(
            Product::latest()
                ->limit(4)
                ->get());
        if (auth()->check()){
            $recommended = ProductForCardResource::collection(auth()->user()->recommendedProducts());
        }
        $popular = ProductForCardResource::collection(
            Product::withAvg('reviews', 'rating')
                ->orderBy('reviews_avg_rating', 'desc')
                ->limit(4)
                ->get());
        return Inertia::render('Index', [
            'newArrival' => $newArrival,
            'recommended' => $recommended ?? [],
            'popular' => $popular,
        ]);
    }
}
