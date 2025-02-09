<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PagesController;

Route::get('/', [PagesController::class, 'welcome'])->name('welcome');

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->middleware(['can:admin'])->group(function () {
        Route::get('/dashboard', [PagesController::class, 'dashboard'])->name('admin.dashboard');

        Route::prefix('products')->group(function () {
            Route::get('/create', [PagesController::class, 'createProduct'])->name('admin.products.create');
            Route::get('/', [PagesController::class, 'listProducts'])->name('admin.products.index');
        });

        Route::prefix('clients')->group(function () {
            Route::get('/create', [PagesController::class, 'createClient'])->name('admin.clients.create');
            Route::get('/', [PagesController::class, 'listClients'])->name('admin.clients.index');
            Route::get('/{id}', [PagesController::class, 'client'])->name('admin.clients.show');
        });

        Route::get('/orders', [PagesController::class, 'orders'])->name('admin.orders.index');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [PagesController::class, 'products'])->name('products.index');
        Route::get('/{id}', [PagesController::class, 'product'])->name('products.show');
    });

    Route::get('/my-orders', [PagesController::class, 'myorders'])->name('orders.my');

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
    });
});

require __DIR__.'/auth.php';



