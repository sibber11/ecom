<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetSlugRequest;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BrandController extends Controller
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
                        ->orWhere('name', 'LIKE', "%{$value}%");
                });
            });
        });
        $brands = QueryBuilder::for(Brand::class)
            ->defaultSort('name')
            ->allowedSorts(['name'])
            ->allowedFilters(['name', $globalSearch])
            ->paginate(\request()->input('perPage')??10)
            ->withQueryString();
        return Inertia::render('Admin/Brand/Index', [
            'brands' => $brands
        ])->table(function (InertiaTable $table){
            $table->defaultSort('name');
            $table->withGlobalSearch();
            $table->column('name', 'Brand Name', sortable: true, searchable: true);
            $table->column('slug', 'Slug');
            $table->column(label: 'Actions');
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Brand/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $brand = new Brand();
        $brand->fill($request->validated());
        $brand->save();
        return to_route('admin.brands.index')
            ->with('success', 'Brand created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return Inertia::render('Admin/Brand/Edit',[
            'brand' => $brand
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $brand->update($request->validated());
        return to_route('admin.brands.index')
            ->with('success', 'Brand updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        if ($brand->products()->count() > 0){
            return to_route('admin.brands.index')
                ->with('error', 'Brand has product. Delete Failed!');
        }
        $brand->delete();
        return to_route('admin.brands.index')
            ->with('success', 'Brand deleted successfully');
    }

    /**
     * returns the brands from the request name
     */
    public function get_names(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255'
        ]);
        return Brand::select('id', 'name')->where('name', 'like',$request->input('name').'%')->limit(10)->get();

    }

    public function get_slug(GetSlugRequest $request)
    {
        $brand = new Brand($request->validated());
        $brand->generateSlug();
        return $brand;
    }
}
