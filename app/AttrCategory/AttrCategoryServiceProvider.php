<?php

namespace App\AttrCategory;
use App\AttrCategory\Domain\Contracts\AttrCategoryRepositoryPort;
use App\AttrCategory\Adapters\Repositories\AttrCategoryRepository;
use Illuminate\Support\ServiceProvider;


class AttrCategoryServiceProvider  extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AttrCategoryRepositoryPort::class, AttrCategoryRepository::class);
    }
    public function boot() {}

}
