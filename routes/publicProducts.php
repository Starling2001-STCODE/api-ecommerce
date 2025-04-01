<?php

use App\Product\Adapters\Controllers\ProductPublicController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest.session', 'timer'])->group(function () {
    Route::get('/products', [ProductPublicController::class, 'getProductPublic'])
    ->name('products.public.index');

    Route::get('/products/{product}', [ProductPublicController::class, 'showProductPublic'])
    ->name('products.public.show');
});