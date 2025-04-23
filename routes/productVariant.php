<?php

use App\ProductVariant\Adapters\Controllers\ProductVariantController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products.variants', ProductVariantController::class);
});
