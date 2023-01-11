<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

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
    Route::resource('categories', \App\Http\Controllers\CategoryController::class)
    ->except('show');
    Route::post('categories/get_names', [\App\Http\Controllers\CategoryController::class, 'get_names'])
        ->name('categories.get_names');
    Route::post('categories/get_slug', [\App\Http\Controllers\CategoryController::class, 'get_slug'])
        ->name('categories.get_slug');

    Route::resource('brands', \App\Http\Controllers\BrandController::class);
    Route::post('brands/get_names', [\App\Http\Controllers\BrandController::class, 'get_names'])
        ->name('brands.get_names');
    Route::post('brands/get_slug', [\App\Http\Controllers\BrandController::class, 'get_slug'])
        ->name('brands.get_slug');
});

require __DIR__.'/auth.php';
