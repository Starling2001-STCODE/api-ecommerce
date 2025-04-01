<?php

use App\AttributeValue\Adapters\Controllers\AttributeValueController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('attributeValues', AttributeValueController::class);
});
