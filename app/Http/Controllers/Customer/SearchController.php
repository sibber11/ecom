<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductForSearchResource;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:1',
        ]);
        //use spatie query builder to search products
        $products = Product::query()
            ->withAvg('reviews', 'rating')
            ->where('name', 'like', '%' . $request->input('query') . '%')
            ->orWhere('description', 'like', '%' . $request->input('query') . '%')
            ->paginate(5);
        return ProductForSearchResource::collection($products);
    }
}
