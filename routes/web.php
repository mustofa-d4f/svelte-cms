<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', HomeController::class)->name('home');
Route::get('/arsip', [PostController::class, 'index'])->name('archive');
Route::get('/artikel/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/tentang-kami', [PageController::class, 'about'])->name('pages.about');
Route::get('/kontak', [PageController::class, 'contact'])->name('pages.contact');

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])
        ->middleware('permission:view dashboard')
        ->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('posts', AdminPostController::class)->middleware('permission:manage posts');
        Route::resource('categories', CategoryController::class)->middleware('permission:manage categories');
        Route::resource('tags', TagController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('permission:manage tags');
        Route::resource('media', MediaController::class)->only(['index', 'store', 'destroy'])->middleware('permission:manage media');
    });
});

require __DIR__.'/settings.php';
