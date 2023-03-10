<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetSlugRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryController extends Controller
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
        $categories = QueryBuilder::for(Category::class)
            ->defaultSort('name')
            ->allowedSorts(['name'])
            ->allowedFilters(['name', $globalSearch])
            ->paginate(\request()->input('perPage') ?? 9)
            ->withQueryString();
        //$categories = Category::with(['ancestors', 'parent'])->withCount('children')->withCount('descendants')->paginate(10);


        return Inertia::render('Admin/Category/Index', [
            'categories' => $categories
        ])->table(function (InertiaTable $table) {
            $table->defaultSort('name')
                ->withGlobalSearch()
                ->column('name', sortable: true, searchable: true)
                ->column('image')
                ->column('slug')
                ->column('parent_name')
                ->column('actions');
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Category/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {

        $category = new Category();
        $this->fill_n_save($category, $request);

        return to_route('categories.index')
            ->with('success', 'Category created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return Inertia::render('Admin/Category/Edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {

        $this->fill_n_save($category, $request);
        return to_route('categories.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->children()->count() > 0) {
            return back()->with('error', 'Category has children');
        }
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Category has products');
        }
        $category->delete();
        //todo return back to the page user came from with the page number
        return to_route('categories.index')
            ->with('success', 'Category deleted successfully');
    }

    public function get_names(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255'
        ]);

        return Category::select('id', 'name')->where('name', 'like', $request->input('name') . '%')->limit(10)->get();
    }

    public function get_slug(GetSlugRequest $request)
    {
        $category = new Category($request->validated());
        $category->generateSlug();
        return $category;
    }

    /**
     * @param Category $category
     * @param StoreCategoryRequest $request
     * @return void
     */
    public function fill_n_save(Category $category, Request $request): void
    {
        $category->fill($request->validated());
        if ($request->input('parent_name') != '') {
            $parent = Category::whereName($request->input('parent_name'))->first();
            $category->appendToNode($parent);
        }
        $category->save();
        if ($request->hasFile('images')) {
            $category->addMediaFromRequest('images')->toMediaCollection('category_images');
        }
    }

    public function deleteMedia(Category $category, Media $media)
    {
        $category->deleteMedia($media);
        return back()
            ->with('success', 'Product image deleted successfully');
    }
}
