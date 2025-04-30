<?php

namespace App\Auth;

use App\Auth\Adapters\Repositories\AuthRepository;
use App\Auth\Domain\Contracts\AuthRepositoryPort;
use App\Auth\Domain\Contracts\GoogleAuthProviderPort;
use App\Auth\Adapters\Providers\GoogleAuthProvider;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AuthRepositoryPort::class, AuthRepository::class);
        $this->app->bind(GoogleAuthProviderPort::class, GoogleAuthProvider::class);
    }

    public function boot() {}
}
