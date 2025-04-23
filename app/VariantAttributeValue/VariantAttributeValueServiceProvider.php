<?php

namespace App\VariantAttributeValue;
use App\VariantAttributeValue\Adapters\Repositories\VariantAttributeValueRepository;
use App\VariantAttributeValue\Domain\Contracts\VariantAttributeValueRepositoryPort;
use Illuminate\Support\ServiceProvider;


class VariantAttributeValueServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(VariantAttributeValueRepositoryPort::class, VariantAttributeValueRepository::class);
    }

    public function boot() {}
}