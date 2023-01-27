<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Index', [
        'newArrival' => \App\Models\Product::latest()->limit(4)->get(),
        'recommended' => \App\Models\Product::inRandomOrder()->limit(8)->get(),
    ]);
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::post('products/get_slug', [\App\Http\Controllers\ProductController::class, 'get_slug'])
        ->name('products.get_slug');
    Route::delete('products/{product}/{media}', [\App\Http\Controllers\ProductController::class, 'deleteMedia'])->name('products.deleteMedia');

    Route::resource('categories', \App\Http\Controllers\CategoryController::class)
        ->except('show');
    Route::post('categories/get_names', [\App\Http\Controllers\CategoryController::class, 'get_names'])
        ->name('categories.get_names');
    Route::post('categories/get_slug', [\App\Http\Controllers\CategoryController::class, 'get_slug'])
        ->name('categories.get_slug');
    Route::delete('categories/{category}/{media}', [\App\Http\Controllers\CategoryController::class, 'deleteMedia'])
        ->name('categories.deleteMedia');

    Route::resource('brands', \App\Http\Controllers\BrandController::class);
    Route::post('brands/get_names', [\App\Http\Controllers\BrandController::class, 'get_names'])
        ->name('brands.get_names');
    Route::post('brands/get_slug', [\App\Http\Controllers\BrandController::class, 'get_slug'])
        ->name('brands.get_slug');

    Route::resource('users', \App\Http\Controllers\UserController::class);
});

Route::post('cart/{product}', [\App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
Route::post('wishlist/{product}', [\App\Http\Controllers\WishlistController::class, 'store'])->name('wishlist.store');
Route::delete('wishlist/{rowId}', [\App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.delete');

Route::get('products/{product}', function (\App\Models\Product $product) {
    return Inertia::render('Customer/Product', [
        'product' => $product,
    ]);
})->name('products.show');
require __DIR__ . '/auth.php';
