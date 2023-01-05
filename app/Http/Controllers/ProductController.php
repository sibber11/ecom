<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetSlugRequest;
use App\Models\Category;
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
            'products' => Product::with(['category', 'tags'])->paginate(4)
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
        $product = new Product;
        $product->fill($request->validated());
        //associate category
        $product->category()->associate(Category::where('name', $request->category)->first());
        $product->save();
        //extract tags from request
        $tags = explode(',', $request->tags);
        $product->syncTags($tags);
        return to_route('products.index')
            ->with('success', 'Product created successfully');
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
            'product' => $product->load(['category', 'tags'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->fill($request->validated());
        //associate category
        $product->category()->associate(Category::where('name', $request->category)->first());
        // extract the tags into an array
        $tags = explode(',', $request->tags);
        $product->syncTags($tags);
        $product->save();
        return to_route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //todo check relation before deleting
        $product->delete();
        return to_route('products.index')
            ->with('success', 'Product deleted successfully');
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
