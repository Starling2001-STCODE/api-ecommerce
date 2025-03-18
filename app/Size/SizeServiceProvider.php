<?php

namespace App\Size;

use Illuminate\Support\ServiceProvider;
use App\Size\Domain\Contracts\SizeRepositoryPort;
use App\Size\Adapters\Repositories\SizeRepository;

class SizeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SizeRepositoryPort::class, SizeRepository::class);
    }

    public function boot() {}
}
