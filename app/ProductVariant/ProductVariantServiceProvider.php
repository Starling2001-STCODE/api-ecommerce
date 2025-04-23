<?php

namespace App\ProductVariant;
use App\ProductVariant\Adapters\Repositories\ProductVariantRepository;
use App\ProductVariant\Domain\Contracts\ProductVariantRepositoryPort;
use Illuminate\Support\ServiceProvider;


class ProductVariantServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProductVariantRepositoryPort::class, ProductVariantRepository::class);
    }

    public function boot() {}
}
