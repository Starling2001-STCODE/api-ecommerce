<?php

use Illuminate\Support\Facades\Route;
use App\Order\Adapters\Controllers\OrderController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('orders', OrderController::class)->only(['index', 'show']);
});
