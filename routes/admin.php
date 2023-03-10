<?php

use Inertia\Inertia;

Route::middleware(['auth','admin'])->group(function (){
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/', function (){
        return Inertia::render('Dashboard');
    });

    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::post('products/get_slug', [\App\Http\Controllers\Admin\ProductController::class, 'get_slug'])
        ->name('products.get_slug');
    Route::delete('products/{product}/{media}', [\App\Http\Controllers\Admin\ProductController::class, 'deleteMedia'])->name('products.deleteMedia');

    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)
        ->except('show');
    Route::post('categories/get_names', [\App\Http\Controllers\Admin\CategoryController::class, 'get_names'])
        ->name('categories.get_names');
    Route::post('categories/get_slug', [\App\Http\Controllers\Admin\CategoryController::class, 'get_slug'])
        ->name('categories.get_slug');
    Route::delete('categories/{category}/{media}', [\App\Http\Controllers\Admin\CategoryController::class, 'deleteMedia'])
        ->name('categories.deleteMedia');

    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class);
    Route::post('brands/get_names', [\App\Http\Controllers\Admin\BrandController::class, 'get_names'])
        ->name('brands.get_names');
    Route::post('brands/get_slug', [\App\Http\Controllers\Admin\BrandController::class, 'get_slug'])
        ->name('brands.get_slug');

    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)
        ->only('index', 'show', 'destroy');
});

require __DIR__ . '/admin_auth.php';
