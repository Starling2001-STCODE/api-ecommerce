<?php

namespace App\Cart;

use App\Cart\Adapters\Repositories\CartRepository;
use App\Cart\Domain\Contracts\CartRepositoryPort;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CartRepositoryPort::class, CartRepository::class);
    }

    public function boot() {}
}
