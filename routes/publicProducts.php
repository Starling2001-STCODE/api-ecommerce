<?php

use App\Product\Adapters\Controllers\ProductPublicController;
use Illuminate\Support\Facades\Route;

Route::middleware(['cors', 'guest.session', 'timer'])->group(function () {
    Route::get('/publicproducts', [ProductPublicController::class, 'getProductPublic'])
        ->name('products.public.index');

    Route::get('/publicproducts/{product}', [ProductPublicController::class, 'showProductPublic'])
        ->name('publicproducts.public.show');
});

Route::get('/cors-test', function () {
    return response()->json(['success' => true]);
})->middleware(['cors']);