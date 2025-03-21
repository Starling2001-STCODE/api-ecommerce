<?php

use App\Cart\Adapters\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest.session', 'timer'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'store']);
});

