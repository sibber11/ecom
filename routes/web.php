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
        'recommended' => \App\Models\Product::limit(8)->get(),
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

/**
 * Cart routes
 */
Route::post('cart/{product}', [\App\Http\Controllers\CartController::class, 'store'])
    ->name('cart.store');
Route::delete('cart/{rowId}', [\App\Http\Controllers\CartController::class, 'destroy'])
    ->name('cart.delete');
Route::get('cart', function () {
    return Inertia::render('Customer/Cart', [
        'products' => \App\Http\Resources\CartItemResource::collection(Cart::instance('cart')->content()),
    ]);
})->name('cart');

Route::get('products/{product}', [\App\Http\Controllers\Customer\ProductController::class, 'show'])->name('products.show');

Route::middleware('auth')->group(function () {
    /**
     * wishlist routes
     */
    Route::get('wishlist', function () {
        return Inertia::render('Customer/Wishlist', [
            'products' => \App\Http\Resources\CartItemResource::collection(Cart::instance('wishlist')->content()),
        ]);
    })->name('wishlist');
    Route::post('wishlist/{product}', [\App\Http\Controllers\WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('wishlist/{rowId}', [\App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.delete');

    /**
     * checkout routes
     */

    Route::post('checkout', [\App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('checkout', [\App\Http\Controllers\CheckoutController::class, 'show'])->name('checkout.show');


    Route::get('orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::delete('orders/{order}', [\App\Http\Controllers\OrderController::class, 'destroy'])->name('orders.destroy');

    /**
     * profile routes
     */
    Route::get('profile', function () {
        return Inertia::render('Customer/Profile');
    })->name('profile');
    Route::post('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('address', [ProfileController::class, 'editAddress'])->name('address');
    Route::post('address', [\App\Http\Controllers\ProfileController::class, 'updateAddress'])->name('address.store');
    Route::get('password', [ProfileController::class, 'editPassword'])->name('password');
    Route::get('reviews', [\App\Http\Controllers\ProfileController::class, 'showReviews'])->name('reviews.index');

    Route::resource('review', \App\Http\Controllers\ReviewController::class)->only('store');
});

Route::get('login', function () {
    return Inertia::render('Customer/Login');
})->name('login');

Route::get('register', function () {
    return Inertia::render('Customer/Register');
})->name('register');

Route::get('icons', function () {
    return Inertia::render('Icons');
});

require __DIR__ . '/auth.php';
