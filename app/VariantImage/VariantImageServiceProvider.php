<?php

namespace App\VariantImage;

use App\VariantImage\Adapters\Repositories\VariantImageRepository;
use App\VariantImage\Domain\Contracts\VariantImageRepositoryPort;
use Illuminate\Support\ServiceProvider;


class VariantImageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(VariantImageRepositoryPort::class, VariantImageRepository::class);
    }

    public function boot() {}
}
