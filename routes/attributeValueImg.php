<?php

use App\AttributeValueImage\Adapters\Controllers\AttributeValueImageController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/attribute-values/{productId}/images/{attributeValueId}', [AttributeValueImageController::class, 'upload'])
    ->name('attribute-values.images.upload');

    Route::get('/attribute-values/{productId}/images', [AttributeValueImageController::class, 'showByProductId'])
        ->name('attribute-values.images.showByProduct');

    Route::delete('/attribute-values/{imageId}/images', [AttributeValueImageController::class, 'delete'])
        ->name('attribute-values.images.delete');
});
