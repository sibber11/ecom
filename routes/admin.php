<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProductAttributeController;
use Inertia\Inertia;

Route::middleware(['auth','admin'])->group(function (){
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/', function (){
        return Inertia::render('Dashboard');
    });

    Route::resource('products', ProductController::class);
    Route::post('products/get_slug', [ProductController::class, 'get_slug'])
        ->name('products.get_slug');
    Route::delete('products/{product}/{media}', [ProductController::class, 'deleteMedia'])->name('products.deleteMedia');

    Route::resource('categories', CategoryController::class)
        ->except('show');
    Route::post('categories/get_names', [CategoryController::class, 'get_names'])
        ->name('categories.get_names');
    Route::post('categories/get_slug', [CategoryController::class, 'get_slug'])
        ->name('categories.get_slug');
    Route::delete('categories/{category}/{media}', [CategoryController::class, 'deleteMedia'])
        ->name('categories.deleteMedia');

    Route::resource('brands', BrandController::class);
    Route::post('brands/get_names', [BrandController::class, 'get_names'])
        ->name('brands.get_names');
    Route::post('brands/get_slug', [BrandController::class, 'get_slug'])
        ->name('brands.get_slug');

    Route::resource('users', UserController::class);

    Route::resource('orders', OrderController::class);

    Route::resource('attributes', ProductAttributeController::class);

    Route::post('read-notifications', [NotificationController::class, 'readNotifications'])
        ->name('read-notifications');
});

require __DIR__ . '/admin_auth.php';
