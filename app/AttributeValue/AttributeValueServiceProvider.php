<?php

namespace App\AttributeValue;

use App\AttributeValue\Adapters\Repositories\AttributeValueRepository;
use App\AttributeValue\Domain\Contracts\AttributeValueRepositoryPort;
use Illuminate\Support\ServiceProvider;

class AttributeValueServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AttributeValueRepositoryPort::class, AttributeValueRepository::class);
    }

    public function boot() {}
}
