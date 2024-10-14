<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\api\OrderController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::patch('/product/{id}', [ProductController::class, 'update'])->name('product.update');

    Route::get('/clients', [ClientController::class, 'index'])->name('client.index');
    Route::get('/client/{id}', [ClientController::class, 'show'])->name('client.show');
    Route::post('/client', [ClientController::class, 'store'])->name('client.store');
    Route::patch('/client/{id}', [ClientController::class, 'update'])->name('client.update');
    Route::delete('/client/{id}', [ClientController::class, 'destroy'])->name('client.destroy');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::patch('/order/{id}', [OrderController::class, 'update'])->name('order.update');
    Route::delete('/order/{id}', [OrderController::class, 'destroy'])->name('order.destroy');

    Route::get('/allorders', [OrderController::class, 'allOrderIndex'])->name('allOrder.index');
    Route::post('/sendorder', [OrderController::class, 'sendOrderStore'])->name('sendOrder.store');
});
