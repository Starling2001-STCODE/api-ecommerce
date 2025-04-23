<?php

use App\Product\Adapters\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products/{product}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::post('/products/{product}/inventory', [ProductController::class, 'storeSimpleInventory'])->name('products.inventory.store');
    Route::apiResource('products', ProductController::class);
});
