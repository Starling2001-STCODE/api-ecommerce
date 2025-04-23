<?php

use App\VariantImage\Adapters\Controllers\VariantImageController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/variants/{productId}/images', [VariantImageController::class, 'upload'])
    ->name('variants.images.upload');

    Route::get('/variants/{productId}/images', [VariantImageController::class, 'showByVariantId'])
    ->name('variants.images.showByProduct');

    Route::delete('/variants/{imageId}/images', [VariantImageController::class, 'delete'])
    ->name('variants.images.delete');
});
