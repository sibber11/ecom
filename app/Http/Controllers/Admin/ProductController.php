<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetSlugRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $products = QueryBuilder::for(Product::class)
            ->defaultSort('name')
            ->allowedSorts(['name', 'id', 'category_id', 'brand_id'])
            ->allowedFilters(['name'])
            ->paginate(\request()->input('perPage') ?? 9)
            ->withQueryString();

        return Inertia::render('Admin/Product/Index', [
            'products' => $products
        ])->table(function (InertiaTable $table) {
            $table->withGlobalSearch()
                ->column('id',sortable: true)
                ->column('name', sortable: true, searchable: true)
                ->column('sku')
                ->column('brand')
                ->column('category')
                ->column('quantity')
                ->column(label: 'actions')
                ->defaultSort('name');
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Product/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();
        $product = new Product;
        $this->fill_n_save($request, $product);

        DB::commit();
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
        return Inertia::render('Admin/Product/Edit', [
            'product' => $product->load(['category', 'tags'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        DB::beginTransaction();
        $this->fill_n_save($request, $product);
        DB::commit();
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
    public function get_slug(GetSlugRequest $request)
    {
        $product = new Product($request->validated());
        $product->generateSlug();
        return $product;
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function fill_n_save(Request $request, Product $product): void
    {
        $product->fill($request->validated());
        $product->category()->associate(Category::whereName($request->category)->first());
        $product->brand()->associate(Brand::whereName($request->input('brand'))->first());
        $product->save();
        //extract tags from request
        if (is_string($request->tags)){
            $tags = explode(',', $request->tags);
        }else{
            $tags = $request->tags;
        }

        $product->syncTags($tags);
        if ($request->hasFile('images')) {
            $product->addMultipleMediaFromRequest(['images'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection('product_images');
                });
        }
    }

    public function deleteMedia(Product $product, Media $media)
    {
        $product->deleteMedia($media);
        return back()
            ->with('success', 'Product image deleted successfully');
    }
}
