<?php

namespace App\InventoryTransaction\Domain\Services;

use App\InventoryTransaction\Domain\Contracts\InventoryTransactionRepositoryPort;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class  ListInventoryTransactionsService
{
    private InventoryTransactionRepositoryPort $inventoryTransactionRepository;

    public function __construct(InventoryTransactionRepositoryPort $inventoryTransactionRepository)
    {
        $this->inventoryTransactionRepository = $inventoryTransactionRepository;
    }

    public function execute(int $perPage): LengthAwarePaginator
    {
        return $this->inventoryTransactionRepository->getAll($perPage);
    }
}
