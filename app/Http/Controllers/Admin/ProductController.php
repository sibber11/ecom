<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetSlugRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Exceptions\MediaCannotBeDeleted;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%$value%");
                });
            });
        });
        $products = QueryBuilder::for(Product::class)
            ->allowedSorts(['name', 'id'])
            ->allowedFilters([
                'name',
                $globalSearch,
                AllowedFilter::exact('category', 'category_id'),
                AllowedFilter::exact('brand', 'brand_id')])
            ->paginate(request()->input('perPage') ?? 9)
            ->withQueryString();

        return Inertia::render('Admin/Product/Index', [
            'products' => $products
        ])->table(function (InertiaTable $table) {
            $table->withGlobalSearch()
                ->column('id', sortable: true)
                ->column('name', sortable: true, searchable: true)
                ->column('sku')
                ->column('brand')
                ->column('category')
                ->column('quantity', 'stock')
                ->column(label: 'actions')
                ->selectFilter('category' , Category::orderBy('name')->get()->pluck('name','id')->toArray())
                ->selectFilter('brand' , Brand::orderBy('name')->get()->pluck('name','id')->toArray())
            ;
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $options = Attribute::all();
        return Inertia::render('Admin/Product/Create',
            [
                'options' => $options
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     * @throws Throwable
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        $product = new Product;
        $this->fill_n_save($request, $product);

        DB::commit();
        return to_route('admin.products.index')
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
    public function edit(Product $product): Response
    {
        return Inertia::render('Admin/Product/Edit', [
            'product' => $product->load(['category', 'tags', 'attributes']),
            'options' => Attribute::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        DB::beginTransaction();
        $this->fill_n_save($request, $product);
        DB::commit();
        return to_route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        //todo check relation before deleting
        $product->delete();
        return to_route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }

    /**
     * Returns a unique slug
     */
    public function get_slug(GetSlugRequest $request): Product
    {
        $product = new Product($request->validated());
        $product->generateSlug();
        return $product;
    }

    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function fill_n_save(UpdateProductRequest|StoreProductRequest $request, Product $product): void
    {
        $product->fill($request->validated());
        $product->category()->associate(Category::whereName($request->input('category'))->first());
        $product->brand()->associate(Brand::whereName($request->input('brand'))->first());
        $product->old_price = 0;
        $product->save();
        //extract tags from request
        if (is_string($request->input('tags'))) {
            $tags = explode(',', $request->input('tags'));
        } else {
            $tags = $request->input('tags');
        }
        if (!empty($tags)) {
            $product->syncTags($tags);
        }
        if ($request->hasFile('images')) {
            $product->addMultipleMediaFromRequest(['images'])
                ->each(function ($fileAdder) {
                    $fileAdder->toMediaCollection(Product::MEDIA_COLLECTION);
                });
        }
        if ($request->has('attributes')) {
            $product->syncAttributes($request->input('attributes'));
        }
    }

    /**
     * @throws MediaCannotBeDeleted
     */
    public function deleteMedia(Product $product, Media $media): RedirectResponse
    {
        $product->deleteMedia($media);
        return back()
            ->with('success', 'Product image deleted successfully');
    }
}
