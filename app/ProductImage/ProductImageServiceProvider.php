<?php

namespace App\ProductImage;
use App\ProductImage\Adapters\Repositories\ProductImageRepository;
use App\ProductImage\Domain\Contracts\ProductImageRepositoryPort;
use Illuminate\Support\ServiceProvider;

class ProductImageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProductImageRepositoryPort::class, ProductImageRepository::class);
    }

    public function boot() {}
}
