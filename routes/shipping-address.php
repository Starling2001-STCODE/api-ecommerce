<?php

use App\ShippingAddress\Adapters\Controllers\ShippingAddressController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::get('shipping-address', [ShippingAddressController::class, 'findByUserId']);
    Route::apiResource('shipping-addresses', ShippingAddressController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);
});
