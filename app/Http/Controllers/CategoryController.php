<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetSlugRequest;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return Inertia::render('Category/Index', [
            'categories' => Category::with(['ancestors'])->withCount('children')->withCount('descendants')->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Category/Create');
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
        return Inertia::render('Category/Edit',[
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
        if ($category->products()->count() > 0){
            return back()->with('error', 'Category has products');
        }
        $category->delete();
        return to_route('categories.index')
            ->with('success', 'Category deleted successfully');
    }

    public function get_names(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255'
        ]);

        return Category::select('id', 'name')->where('name', 'like',$request->input('name').'%')->limit(10)->get();
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
        if ($request->input('parent') != '') {
            $parent = Category::whereName($request->input('parent'))->first();
            $category->appendToNode($parent);
        }
        $category->save();
    }
}
