<?php

namespace App\Attribute;

use App\Attribute\Adapters\Repositories\AttributeRepository;
use App\Attribute\Domain\Contracts\AttributeRepositoryPort;
use Illuminate\Support\ServiceProvider;

class AttributeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AttributeRepositoryPort::class, AttributeRepository::class);
    }

    public function boot() {}
}
