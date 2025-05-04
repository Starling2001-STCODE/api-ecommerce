<?php

use App\InventoryTransaction\Adapters\Controllers\InventoryTransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('inventory-transactions', [InventoryTransactionController::class, 'index']);
    Route::post('inventory-transactions/purchases', [InventoryTransactionController::class, 'createPurchase']);
    Route::post('inventory-transactions/sales', [InventoryTransactionController::class, 'createSale']);

    Route::prefix('inventory-transactions')->group(function () {
        Route::get('{id}/product', [InventoryTransactionController::class, 'showById']);
        Route::get('by-product/{product_id}', [InventoryTransactionController::class, 'getByProductId']);
        Route::get('by-variant/{variant_id}', [InventoryTransactionController::class, 'getByVariantId']);
    }); 
    // Route::post('inventory-transactions/adjustments', [InventoryTransactionController::class, 'createAdjustment']);
    // Route::post('inventory-transactions/transfers', [InventoryTransactionController::class, 'createTransfer']);
    // Route::patch('inventory-transactions/{id}/cancel', [InventoryTransactionController::class, 'cancelTransfer']);
    // Route::patch('inventory-transactions/transfers/{id}/accept', [InventoryTransactionController::class, 'acceptTransfer']);
});
