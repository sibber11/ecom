<?php

use App\Http\Controllers\Customer\ProfileController;
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


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * Cart routes
 */
Route::post('cart/{product}', [\App\Http\Controllers\Customer\CartController::class, 'store'])
    ->name('cart.store');
Route::delete('cart/{rowId}', [\App\Http\Controllers\Customer\CartController::class, 'destroy'])
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
    Route::post('wishlist/{product}', [\App\Http\Controllers\Customer\WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('wishlist/{rowId}', [\App\Http\Controllers\Customer\WishlistController::class, 'destroy'])->name('wishlist.delete');

    /**
     * checkout routes
     */

    Route::post('checkout', [\App\Http\Controllers\Customer\CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('checkout', [\App\Http\Controllers\Customer\CheckoutController::class, 'show'])->name('checkout.show');


    Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::delete('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('orders.destroy');

    /**
     * profile routes
     */
    Route::get('profile', function () {
        return Inertia::render('Customer/Profile');
    })->name('profile');
    Route::post('profile', [\App\Http\Controllers\Customer\ProfileController::class, 'update'])->name('profile.update');
    Route::get('address', [ProfileController::class, 'editAddress'])->name('address');
    Route::post('address', [\App\Http\Controllers\Customer\ProfileController::class, 'updateAddress'])->name('address.store');
    Route::get('password', [ProfileController::class, 'editPassword'])->name('password');
    Route::get('reviews', [\App\Http\Controllers\Customer\ProfileController::class, 'showReviews'])->name('reviews.index');

    Route::resource('review', \App\Http\Controllers\Customer\ReviewController::class)->only('store');
});

Route::get('icons', function () {
    return Inertia::render('Icons');
});

require __DIR__ . '/auth.php';
