<?php

use App\Cart\Adapters\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest.session', 'timer'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'store']); 
    Route::get('/cart/show', [CartController::class, 'show']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/cart/migrate', [CartController::class, 'migrateGuestCart']);  
    Route::post('/cart/item', [CartController::class, 'addItem']);
    Route::patch('/cart/item', [CartController::class, 'updateItem']);
    Route::delete('/cart/item', [CartController::class, 'removeItem']);
});
