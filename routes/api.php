<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\OrderController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('products', ProductController::class);

    Route::get('companies/without-user', [CompanyController::class, 'findCompaniesWithoutUser']);
    Route::apiResource('companies', CompanyController::class);

    Route::apiResource('clients', ClientController::class);

    Route::prefix('orders')->group(function () {
        Route::post('', [OrderController::class, 'store']);
        Route::get('', [OrderController::class, 'show']);
        Route::patch('{id}/add-product', [OrderController::class, 'addToOrder']);
        Route::patch('{id}/increment-product', [OrderController::class, 'incrementProduct']);
        Route::patch('{id}/decrement-product', [OrderController::class, 'decrementProduct']);
        Route::patch('{id}/remove-product', [OrderController::class, 'removeProduct']);
    });
});

