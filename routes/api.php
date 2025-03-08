<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\OrderController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('products', ProductController::class);

    Route::apiResource('companies', CompanyController::class);

    Route::apiResource('clients', ClientController::class);

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::apiResource('/', OrderController::class)->except(['show']);

        Route::get('in-progress', [OrderController::class, 'ordersInProgress'])->name('inProgress');
        Route::get('completed', [OrderController::class, 'ordersCompleted'])->name('completed');
        Route::get('all', [OrderController::class, 'allOrders'])->name('all');
        Route::get('all-in-progress', [OrderController::class, 'allOrdersInProgress'])->name('allInProgress');
    });
});

