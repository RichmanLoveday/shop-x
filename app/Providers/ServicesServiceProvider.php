<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    public array $bindings = [
        \App\Services\Contracts\User\Auth\SocialAuthServiceInterface::class => \App\Services\User\Auth\SocialAuthService::class,
        \App\Services\Contracts\User\Auth\HcaptchaServiceInterface::class => \App\Services\User\Auth\HcaptchaService::class,
        \App\Services\Contracts\User\ProfileServiceInterface::class => \App\Services\User\ProfileService::class,
        \App\Services\Contracts\Admin\ProfileServiceInterface::class => \App\Services\Admin\ProfileService::class,
        \App\Services\Contracts\Vendor\KycServiceInterface::class => \App\Services\Vendor\KycService::class,
        \App\Services\Contracts\Admin\KycServiceInterface::class => \App\Services\Admin\KycService::class,
        \App\Services\Contracts\Vendor\StoreServiceInterface::class => \App\Services\Vendor\StoreService::class,
        \App\Services\Contracts\Admin\RoleServiceInterface::class => \App\Services\Admin\RoleService::class,
        \App\Services\Contracts\Admin\RoleUserServiceInterface::class => \App\Services\Admin\RoleUserService::class,
        \App\Services\Contracts\Admin\SettingsServiceInterface::class => \App\Services\Admin\SettingsService::class,
        \App\Services\Contracts\Admin\CategoryServiceInterface::class => \App\Services\Admin\CategoryService::class,
        \App\Services\Contracts\Admin\ProductServiceInterface::class => \App\Services\Admin\ProductService::class,
        \App\Services\Contracts\Admin\TagServiceInterface::class => \App\Services\Admin\TagService::class,
        \App\Services\Contracts\Admin\BrandServiceInterface::class => \App\Services\Admin\BrandService::class,
        \App\Services\Contracts\Admin\StoreServiceInterface::class => \App\Services\Admin\StoreService::class,
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
    public function boot(): void {}
}
