<?php

use App\Cart\Adapters\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest.session', 'timer'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'store']);
    // Route::post('/cart/update', [CartController::class, 'update']);
    // Route::post('/cart/remove', [CartController::class, 'remove']);
    Route::get('/cart/show', [CartController::class, 'show']);
});

// Rutas privadas (usuario logueado)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/cart/migrate', [CartController::class, 'migrateGuestCart']);
    // Route::post('/cart/checkout', [OrderController::class, 'store']); // ejemplo
});