<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        \App\Repositories\Contracts\User\Auth\UserAuthRepositoryInterface::class => \App\Repositories\Eloquent\User\Auth\UserAuthRepository::class,
        \App\Repositories\Contracts\Admin\AdminRepositoryInterface::class => \App\Repositories\Eloquent\Admin\AdminRepository::class,
        \App\Repositories\Contracts\Vendor\KycRepositoryInterface::class => \App\Repositories\Eloquent\Vendor\KycRepository::class,
        \App\Repositories\Contracts\Admin\KycRepositoryInterface::class => \App\Repositories\Eloquent\Admin\KycRepository::class,
        \App\Repositories\Contracts\Vendor\StoreRepositoryInterface::class => \App\Repositories\Eloquent\Vendor\StoreRepository::class,
        \App\Repositories\Contracts\Admin\SettingsRepositoryInterface::class => \App\Repositories\Eloquent\Admin\SettingsRepository::class,
        \App\Repositories\Contracts\Admin\ProductRepositoryInterface::class => \App\Repositories\Eloquent\Admin\ProductRepository::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
