<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\OrderController;

Route::middleware(['auth:sanctum'])->group(function () {

    Route::apiResource('products', ProductController::class);

    Route::apiResource('clients', ClientController::class);

    Route::apiResource('orders', OrderController::class)->except(['show']);

    Route::get('/orders/in-progress', [OrderController::class, 'ordersInProgress'])->name('orders.inProgress');
    Route::get('/orders/completed', [OrderController::class, 'ordersCompleted'])->name('orders.completed');
    Route::get('/orders/all', [OrderController::class, 'allOrders'])->name('orders.all');
    Route::get('/orders/all-in-progress', [OrderController::class, 'allOrdersInProgress'])->name('orders.allInProgress');
});
