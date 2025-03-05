<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PagesController;

Route::get('/', [PagesController::class, 'welcome'])->name('welcome');

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->name('admin.')->middleware(['can:admin'])->group(function () {
        Route::get('/dashboard', [PagesController::class, 'dashboard'])->name('dashboard');

        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/create', [PagesController::class, 'createProduct'])->name('create');
            Route::get('/', [PagesController::class, 'listProducts'])->name('index');
            Route::get('/{id}', [PagesController::class, 'product'])->name('show');
            Route::get('/edit/{id}', [PagesController::class, 'editProduct'])->name('edit');
        });

        Route::prefix('companies')->name('companies.')->group(function () {
            Route::get('/create', [PagesController::class, 'createCompanies'])->name('create');
            Route::get('/', [PagesController::class, 'listCompanies'])->name('index');
            Route::get('/{id}', [PagesController::class, 'company'])->name('show');
            Route::get('/edit/{id}', [PagesController::class, 'editCompanies'])->name('edit');
        });

        Route::prefix('clients')->name('clients.')->group(function () {
            Route::get('/create', [PagesController::class, 'createClient'])->name('create');
            Route::get('/', [PagesController::class, 'listClients'])->name('index');
            Route::get('/{id}', [PagesController::class, 'client'])->name('show');
        });

        Route::get('/orders', [PagesController::class, 'orders'])->name('orders.index');
    });

    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [PagesController::class, 'products'])->name('list');
        Route::get('/{id}', [PagesController::class, 'product'])->name('view');
    });

    Route::get('/my-orders', [PagesController::class, 'myorders'])->name('orders.my');

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
    });
});

require __DIR__.'/auth.php';



