<?php

    namespace App\InventoryTransaction\Domain\Services;

    use App\Inventory\Domain\Contracts\InventoryRepositoryPort;
    use App\InventoryTransaction\Domain\Contracts\InventoryTransactionRepositoryPort;
    use App\InventoryTransaction\Domain\Entities\InventoryTransaction;
    use Illuminate\Support\Facades\DB;

    class CreatePurchaseService
    {
        private  InventoryTransactionRepositoryPort $inventoryTransactionRepository;
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
                $inventoryTransaction = new InventoryTransaction($data);
                $this->inventoryRepository->incrementStock($data['products']);
                $this->inventoryTransactionRepository->createPurchase($inventoryTransaction);
            });
        }
    }
