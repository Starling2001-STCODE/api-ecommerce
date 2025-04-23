<?php

use App\Product\Adapters\Controllers\ProductPublicController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest.session', 'timer'])->group(function () {
    Route::get('/publicproducts', [ProductPublicController::class, 'getProductPublic'])
    ->name('products.public.index');

    Route::get('/publicproducts/{product}', [ProductPublicController::class, 'showProductPublic'])
    ->name('publicproducts.public.show');
});