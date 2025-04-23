<?php

use App\AttrCategory\Adapters\Controllers\AttrCategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('attrCategory', AttrCategoryController::class);
});
