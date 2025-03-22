<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\OrderController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('products', ProductController::class);

    Route::get('/companies/unsign', [CompanyController::class, 'companiesUnsign']);
    Route::apiResource('companies', CompanyController::class);

    Route::apiResource('clients', ClientController::class);

    Route::apiResource('orders', OrderController::class);
});

