<?php

namespace App\InventoryTransaction\Domain\Contracts;

use App\InventoryTransaction\Domain\Entities\InventoryTransaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface InventoryTransactionRepositoryPort
{

    public function createPurchase(InventoryTransaction $inventoryTransaction): void;

    public function createAdjustment(InventoryTransaction $inventoryTransaction): void;

    public function createSale(InventoryTransaction $inventoryTransaction): void;

    public function createReturn(InventoryTransaction $inventoryTransaction): void;

    public function findById(string $id): InventoryTransaction;

    public function getAllByProductId(string $product_id): Collection;

    public function getAllByProductVariantId(string $product_variant_id): Collection;

    public function delete(string $id): int;

    public function getAll(int $perPage): LengthAwarePaginator;
}