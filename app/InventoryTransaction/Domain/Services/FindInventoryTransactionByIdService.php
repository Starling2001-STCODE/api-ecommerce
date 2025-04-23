<?php

namespace App\InventoryTransaction\Domain\Services;
use App\InventoryTransaction\Domain\Contracts\InventoryTransactionRepositoryPort;
use App\InventoryTransaction\Domain\Entities\InventoryTransaction;
use Illuminate\Support\Collection;

class FindInventoryTransactionByIdService
{
    private InventoryTransactionRepositoryPort $inventoryTransactionRepository;

    public function __construct(InventoryTransactionRepositoryPort $inventoryTransactionRepository)
    {
        $this->inventoryTransactionRepository = $inventoryTransactionRepository;
    }

    public function execute(string $id): InventoryTransaction
    {
        return $this->inventoryTransactionRepository->findById($id);
    }
    public function getAllByProductId(string $product_id): Collection
    {
        return $this->inventoryTransactionRepository->getAllByProductId($product_id);
    }
    public function getAllByProductVariantId(string $product_variant_id): Collection
    {
        return $this->inventoryTransactionRepository->getAllByProductVariantId($product_variant_id);
    }
}
