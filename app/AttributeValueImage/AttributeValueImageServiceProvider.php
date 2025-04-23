<?php

namespace App\AttributeValueImage;
use App\AttributeValueImage\Adapters\Repositories\AttributeValueImageRepository;
use App\AttributeValueImage\Domain\Contracts\AttributeValueImageRepositoryPort;
use Illuminate\Support\ServiceProvider;
class AttributeValueImageServiceProvider  extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AttributeValueImageRepositoryPort::class, AttributeValueImageRepository::class);
    }

    public function boot() {}
}
