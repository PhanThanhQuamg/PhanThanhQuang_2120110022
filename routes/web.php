<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\SiteController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\BrandController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// TRANG NGƯỜI DÙNG

Route::get('/', [SiteController::class, 'index'])->name('site.home');
Route::get('lien-he', [LienheController::class, 'index'])->name('site.index');
// TRANG QUẢN LÝ

Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Brand
    Route::resource('brand', BrandController::class);
    Route::get('brand_trash', [BrandController::class, 'trash'])->name('brand.trash');
    Route::prefix('brand')->group(function () {
        Route::get('status/{brand}', [BrandController::class, 'status'])->name('brand.status');
        Route::get('delete/{brand}', [BrandController::class, 'delete'])->name('brand.delete');
        Route::get('restore/{brand}', [BrandController::class, 'restore'])->name('brand.restore');
        Route::get('destroy/{brand}', [BrandController::class, 'destroy'])->name('brand.destroy');
    });
    //Category
    Route::resource('category', CategoryController::class);
    Route::get('category_trash', [CategoryController::class, 'trash'])->name('category.trash');
    Route::prefix('category')->group(function () {
        Route::get('status/{category}', [CategoryController::class, 'status'])->name('category.status');
        Route::get('delete/{category}', [CategoryController::class, 'delete'])->name('category.delete');
        Route::get('restore/{category}', [CategoryController::class, 'restore'])->name('category.restore');
        Route::get('destroy/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
    });

    //Product
    Route::resource('product', ProductController::class,);
    Route::get('product_trash', [ProductController::class, 'trash'])->name('product.trash');
    Route::prefix('product')->group(function () {
        Route::get('status/{product}', [ProductController::class, 'status'])->name('product.status');
        Route::get('delete/{product}', [ProductController::class, 'delete'])->name('product.delete');
        Route::get('restore/{product}', [ProductController::class, 'restore'])->name('product.restore');
        Route::get('destroy/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    });
});

Route::get('{slug}', [SiteController::class, 'index'])->name('slug.home');
