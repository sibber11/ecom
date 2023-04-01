<?php

use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\Customer\SearchController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Resources\CartItemResource;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

/**
 * Search routes
 */

Route::get('search', [SearchController::class, 'index'])->name('search');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * Cart routes
 */
Route::post('cart/{product}', [CartController::class, 'store'])
    ->name('cart.store');
Route::patch('cart/{rowId}', [CartController::class, 'update'])
    ->name('cart.update');
Route::delete('cart/{rowId}', [CartController::class, 'destroy'])
    ->name('cart.delete');
Route::get('cart', function () {
    return Inertia::render('Customer/Cart', [
        'products' => CartItemResource::collection(Cart::instance('cart')->content()),
    ]);
})->name('cart');

Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('auth')->group(function () {
    /**
     * wishlist routes
     */
    Route::get('wishlist', function () {
        return Inertia::render('Customer/Wishlist', [
            'products' => CartItemResource::collection(Cart::instance('wishlist')->content()),
        ]);
    })->name('wishlist');
    Route::post('wishlist/{product}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('wishlist/{rowId}', [WishlistController::class, 'destroy'])->name('wishlist.delete');

    /**
     * checkout routes
     */

    Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('checkout', [CheckoutController::class, 'show'])->name('checkout.show');


    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    /**
     * profile routes
     */
    Route::get('profile', function () {
        return Inertia::render('Customer/Profile');
    })->name('profile');
    Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('address', [ProfileController::class, 'editAddress'])->name('address');
    Route::post('address', [ProfileController::class, 'updateAddress'])->name('address.store');
    Route::get('password', [ProfileController::class, 'editPassword'])->name('password');
    Route::get('reviews', [ProfileController::class, 'showReviews'])->name('reviews.index');

    Route::resource('review', ReviewController::class)->only('store');
});

Route::get('icons', function () {
    return Inertia::render('Icons');
});

require __DIR__ . '/auth.php';
