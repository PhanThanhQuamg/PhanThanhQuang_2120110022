<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\SiteController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\PostController;
use App\Http\Controllers\backend\PageController;
use App\Http\Controllers\backend\TopicController;
use App\Http\Controllers\backend\MenuController;
use App\Http\Controllers\backend\SliderController;
use App\Http\Controllers\backend\AuthController;

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
Route::get('san-pham', [SiteController::class, 'product'])->name('site.product');
Route::get('tim-kiem', [SiteController::class, 'search'])->name('site.search');
Route::get('thuong-hieu', [SiteController::class, 'brand'])->name('site.brand');
Route::get('bai-viet', [SiteController::class, 'post'])->name('site.post');
Route::get('khach-hang', [LienheController::class, 'index'])->name('site.index');
Route::get('gio-hang', [LienheController::class, 'index'])->name('site.index');

// Đăng nhập
Route::get('login', [AuthController::class, 'getlogin'])->name('login');
Route::post('login', [AuthController::class, 'postlogin'])->name('postlogin');
// TRANG QUẢN LÝ
Route::group(['prefix' => 'admin', 'middleware' => 'LoginAdmin'], (function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('login', [AuthController::class, 'logout'])->name('logout');

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

    //topic
    Route::resource('topic', TopicController::class);
    Route::get('topic_trash', [TopicController::class, 'trash'])->name('topic.trash');
    Route::prefix('topic')->group(function () {
        Route::get('status/{topic}', [TopicController::class, 'status'])->name('topic.status');
        Route::get('delete/{topic}', [TopicController::class, 'delete'])->name('topic.delete');
        Route::get('restore/{topic}', [TopicController::class, 'restore'])->name('topic.restore');
        Route::get('destroy/{topic}', [TopicController::class, 'destroy'])->name('topic.destroy');
    });

    //page
    Route::resource('page', PageController::class);
    Route::get('page_trash', [PageController::class, 'trash'])->name('page.trash');
    Route::prefix('page')->group(function () {
        Route::get('status/{page}', [PageController::class, 'status'])->name('page.status');
        Route::get('delete/{page}', [PageController::class, 'delete'])->name('page.delete');
        Route::get('restore/{page}', [PageController::class, 'restore'])->name('page.restore');
        Route::get('destroy/{page}', [PageController::class, 'destroy'])->name('page.destroy');
    });

    //post
    Route::resource('post', PostController::class);
    Route::get('post_trash', [PostController::class, 'trash'])->name('post.trash');
    Route::prefix('post')->group(function () {
        Route::get('status/{post}', [PostController::class, 'status'])->name('post.status');
        Route::get('delete/{post}', [PostController::class, 'delete'])->name('post.delete');
        Route::get('restore/{post}', [PostController::class, 'restore'])->name('post.restore');
        Route::get('destroy/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    });

    //menu
    Route::resource('menu', MenuController::class);
    Route::get('menu_trash', [MenuController::class, 'trash'])->name('menu.trash');
    Route::prefix('menu')->group(function () {
        Route::get('status/{menu}', [MenuController::class, 'status'])->name('menu.status');
        Route::get('delete/{menu}', [MenuController::class, 'delete'])->name('menu.delete');
        Route::get('restore/{menu}', [MenuController::class, 'restore'])->name('menu.restore');
        Route::get('destroy/{menu}', [MenuController::class, 'destroy'])->name('menu.destroy');
    });

    //slider
    Route::resource('slider', SliderController::class);
    Route::get('slider_trash', [SliderController::class, 'trash'])->name('slider.trash');
    Route::prefix('slider')->group(function () {
        Route::get('status/{slider}', [SliderController::class, 'status'])->name('slider.status');
        Route::get('delete/{slider}', [SliderController::class, 'delete'])->name('slider.delete');
        Route::get('restore/{slider}', [SliderController::class, 'restore'])->name('slider.restore');
        Route::get('destroy/{slider}', [SliderController::class, 'destroy'])->name('slider.destroy');
    });
    //page
    Route::resource('page', PageController::class);
    Route::get('page_trash', [PageController::class, 'trash'])->name('page.trash');
    Route::prefix('page')->group(function () {
        Route::get('status/{page}', [PageController::class, 'status'])->name('page.status');
        Route::get('delete/{page}', [PageController::class, 'delete'])->name('page.delete');
        Route::get('restore/{page}', [PageController::class, 'restore'])->name('page.restore');
        Route::get('destroy/{page}', [PageController::class, 'destroy'])->name('page.destroy');
    });
}));
Route::get('{slug}', [SiteController::class, 'index'])->name('slug.home');

