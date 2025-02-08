<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PagesController;

Route::get('/', [PagesController::class, 'welcome'])->name('welcome');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware(['can:admin'])->group(function () {
        Route::get('/dashboard', [PagesController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/create_product', [PagesController::class, 'createProduct'])->name('createProduct');
        Route::get('/list_products', [PagesController::class, 'listProducts'])->name('listProducts');
        
        Route::get('/list_clients', [PagesController::class, 'listClients'])->name('listClients');
        Route::get('/create_client', [PagesController::class, 'createClient'])->name('createClient');
        Route::get('/client/{id}', [PagesController::class, 'client'])->name('client');
        
        Route::get('/orders', [PagesController::class, 'orders'])->name('orders');
    });

    Route::get('/products', [PagesController::class, 'products'])->name('products');

    Route::get('/myorders', [PagesController::class, 'myorders'])->name('myorders');

    Route::get('/product/{id}', [PagesController::class, 'product'])->name('product');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';



