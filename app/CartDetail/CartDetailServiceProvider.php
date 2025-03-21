<?php

namespace App\CartDetail;
use App\CartDetail\Adapters\Repositories\CartDetailRepository;
use App\CartDetail\Domain\Contracts\CartDetailRepositoryPort;
use Illuminate\Support\ServiceProvider;

class CartDetailServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CartDetailRepositoryPort::class, CartDetailRepository::class);
    }

    public function boot() {}
}





