<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductForCardResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $newArrival = ProductForCardResource::collection(Product::latest()->limit(4)->get());
        $recommended = ProductForCardResource::collection(Product::limit(8)->get());
        return Inertia::render('Index', [
            'newArrival' => $newArrival,
            'recommended' => $recommended
        ]);
    }
}
