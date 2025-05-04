<?php

namespace App\InventoryTransaction\Domain\Services;

use App\Inventory\Domain\Contracts\InventoryRepositoryPort;
use App\InventoryTransaction\Domain\Contracts\InventoryTransactionRepositoryPort;
use App\InventoryTransaction\Domain\Entities\InventoryTransaction;
use Illuminate\Support\Facades\DB;

class CreateSaleService
{
    private InventoryTransactionRepositoryPort $inventoryTransactionRepository;
    private InventoryRepositoryPort $inventoryRepository;

    public function __construct(
        InventoryTransactionRepositoryPort $inventoryTransactionRepository,
        InventoryRepositoryPort $inventoryRepository
    ) {
        $this->inventoryTransactionRepository = $inventoryTransactionRepository;
        $this->inventoryRepository = $inventoryRepository;
    }

    public function execute(array $data): void
    {
        DB::transaction(function () use ($data) {
            collect($data['products'])
                ->groupBy(fn($product) => is_null($product['product_variant_id']) ? 'simple' : 'variant')
                ->each(function ($products, $type) use ($data) {
                    $inventoryTransaction = new InventoryTransaction([
                        ...$data,
                        'products' => $products->values()->toArray(),
                    ]);
                    $this->inventoryRepository->decrementStock($inventoryTransaction->products);
                    $this->inventoryTransactionRepository->createSale($inventoryTransaction);
                });
        });
    }

}
