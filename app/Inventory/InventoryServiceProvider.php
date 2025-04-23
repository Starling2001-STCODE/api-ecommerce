<?php

namespace App\Inventory;

use App\Inventory\Adapters\Repositories\InventoryRepository;
use App\Inventory\Domain\Contracts\InventoryRepositoryPort;
use Illuminate\Support\ServiceProvider;

class InventoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(InventoryRepositoryPort::class, InventoryRepository::class);
    }

    public function boot() {}
}
