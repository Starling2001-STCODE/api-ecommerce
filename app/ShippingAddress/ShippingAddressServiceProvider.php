<?php

namespace App\ShippingAddress;

use App\ShippingAddress\Adapters\Repositories\ShippingAddressRepository;
use App\ShippingAddress\Domain\Contracts\ShippingAddressRepositoryPort;
use Illuminate\Support\ServiceProvider;

class ShippingAddressServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ShippingAddressRepositoryPort::class, ShippingAddressRepository::class);
    }

    public function boot() {}
}
