<?php

namespace App\InventoryTransaction;

use App\InventoryTransaction\Adapters\Repositories\InventoryTransactionRepository;
use App\InventoryTransaction\Domain\Contracts\InventoryTransactionRepositoryPort;
use Illuminate\Support\ServiceProvider;

class InventoryTransactionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(InventoryTransactionRepositoryPort::class, InventoryTransactionRepository::class);
    }

    public function boot() {}
}
