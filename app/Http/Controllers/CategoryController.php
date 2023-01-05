<?php

namespace App\Http\Controllers;

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
            'categories' => Category::with('ancestors')->paginate(10)
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
        $parent = Category::whereName($request->input('parent'))->first();
        $category = new Category();
        $category->fill($request->validated());
        $category->appendToNode($parent)->save();
        return to_route('categories.index')
            ->with('message', 'Category created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $category->parent = $category->parent?->name;
        return Inertia::render('Category/Edit',[
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $parent = Category::whereName($request->input('parent'))->first();
        $category->fill($request->validated());
        $category->appendToNode($parent)->save();
        return to_route('categories.index')
            ->with('message', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return to_route('categories.index')
            ->with('message', 'Category deleted successfully');
    }

    public function get_category(Request $request)
    {
        $request->validate([
            'category_name' => 'nullable|string|max:255'
        ]);

        return Category::select('id', 'name')->where('name', 'like',$request->input('category_name').'%')->limit(10)->get();
    }
}
