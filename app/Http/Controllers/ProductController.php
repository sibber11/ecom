<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetSlugRequest;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return Inertia::render('Product/Index',[
            'products' => Product::paginate(4)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Product/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());
        return to_route('products.index')
            ->with('message', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return Inertia::render('Product/Edit',[
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        // return to index page with success message "Product updated successfully"
        return to_route('products.index')
            ->with('message', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        // return to index page with success message "Product deleted successfully"
        return to_route('products.index')
            ->with('message', 'Product deleted successfully');
    }

    /**
     * Returns a unique slug
     */
    public function getslug(GetSlugRequest $request){
        $product = new Product($request->validated());
        $product->generateSlug();
        return $product;
    }
}
