<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductAttributeRequest;
use App\Http\Requests\UpdateProductAttributeRequest;
use App\Models\Attribute;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;

class ProductAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $product_attributes = QueryBuilder::for(Attribute::class)
            ->defaultSort('name')
            ->allowedSorts(['name', 'type', 'id'])
            ->allowedFilters(['type'])
            ->paginate(request()->input('perPage') ?? 9)
            ->withQueryString();
        return Inertia::render('Admin/ProductAttribute/Index', [
            'attributes' => $product_attributes
        ])->table(function (InertiaTable $table) {
            $table
                ->column('id', sortable: true)
                ->column('name', sortable: true, searchable: true)
                ->column('type')
                ->column('options')
                ->column(label: 'actions')
                ->defaultSort('name')
                ->selectFilter('type', Attribute::TYPES);
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/ProductAttribute/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductAttributeRequest $request): RedirectResponse
    {
        $product_attribute = new Attribute();
        $product_attribute->fill($request->validated());
        $product_attribute->save();
        $product_attribute->add_options($request->validated()['options']);

        return to_route('admin.attributes.index')->with('success', 'Product Attribute created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attribute $productAttribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute): Response
    {
        return Inertia::render('Admin/ProductAttribute/Edit', [
            'attribute' => $attribute
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductAttributeRequest $request, Attribute $attribute): RedirectResponse
    {

        $attribute->fill($request->validated());

        if ($request->has('options')){
            $attribute->options()->delete();
            $attribute->add_options($request->validated()['options']);
        }

//        dd($request->validated());
        $attribute->save();

        return back()->with('success', 'Product Attribute updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute): RedirectResponse
    {
        if ($attribute->products()->count()){
            return to_route('admin.attributes.index')->with('error', 'Product Attribute can not be deleted!.');
        }
        $attribute->delete();
        return to_route('admin.attributes.index')->with('success', 'Product Attribute deleted successfully.');
    }
}
