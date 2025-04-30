<?php

namespace App\Order;
use App\Order\Adapters\Repositories\OrderRepository;
use App\Order\Domain\Contracts\OrderRepositoryPort;
use App\Order\Domain\Contracts\OrderItemRepositoryPort;
use App\Order\Adapters\Repositories\OrderItemRepository;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(OrderRepositoryPort::class, OrderRepository::class);
        $this->app->bind(OrderItemRepositoryPort::class, OrderItemRepository::class);
    }


    public function boot() {}
}

