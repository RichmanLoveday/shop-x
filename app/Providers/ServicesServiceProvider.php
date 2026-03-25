<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{

    public array $bindings = [
        \App\Services\Contracts\User\Auth\SocialAuthServiceInterface::class => \App\Services\User\Auth\SocialAuthService::class,
        \App\Services\Contracts\User\Auth\HcaptchaServiceInterface::class => \App\Services\User\Auth\HcaptchaService::class,
        \App\Services\Contracts\User\ProfileServiceInterface::class => \App\Services\User\ProfileService::class,
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
