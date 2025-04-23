<?php

use App\ProductImage\Adapters\Controllers\ProductImageController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products/{productId}/images', [ProductImageController::class, 'upload'])
    ->name('products.images.upload');

    Route::get('/products/{productId}/images', [ProductImageController::class, 'showByProductId'])
    ->name('products.images.showByProduct');

    Route::delete('/products/{imageId}/images', [ProductImageController::class, 'delete'])
    ->name('products.images.delete');
});
