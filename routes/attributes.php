<?php

use App\Attribute\Adapters\Controllers\AttributeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('attributes', AttributeController::class);
});
