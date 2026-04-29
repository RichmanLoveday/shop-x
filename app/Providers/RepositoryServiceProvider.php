<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        // core bindings
        \App\Repositories\Contracts\Core\BaseProductRepositoryInterface::class => \App\Repositories\Eloquent\Core\BaseProductRepository::class,
        \App\Repositories\Contracts\Core\BaseCategoryRepositoryInterface::class => \App\Repositories\Eloquent\Core\BaseCategoryRepository::class,
        \App\Repositories\Contracts\Core\BaseBrandRepositoryInterface::class => \App\Repositories\Eloquent\Core\BaseBrandRepository::class,
        \App\Repositories\Contracts\Core\BaseTagRepositoryInterface::class => \App\Repositories\Eloquent\Core\BaseTagRepository::class,
        // Admin Binding
        \App\Repositories\Contracts\User\Auth\UserAuthRepositoryInterface::class => \App\Repositories\Eloquent\User\Auth\UserAuthRepository::class,
        \App\Repositories\Contracts\Admin\AdminRepositoryInterface::class => \App\Repositories\Eloquent\Admin\AdminRepository::class,
        \App\Repositories\Contracts\Admin\KycRepositoryInterface::class => \App\Repositories\Eloquent\Admin\KycRepository::class,
        \App\Repositories\Contracts\Admin\SettingsRepositoryInterface::class => \App\Repositories\Eloquent\Admin\SettingsRepository::class,
        \App\Repositories\Contracts\Admin\ProductRepositoryInterface::class => \App\Repositories\Eloquent\Admin\ProductRepository::class,
        \App\Repositories\Contracts\Admin\CategoryRepositoryInterface::class => \App\Repositories\Eloquent\Admin\CategoryRepository::class,
        \App\Repositories\Contracts\Admin\StoreRepositoryInterface::class => \App\Repositories\Eloquent\Admin\StoreRepository::class,
        \App\Repositories\Contracts\Admin\BrandRepositoryInterface::class =>
            \App\Repositories\Eloquent\Admin\BrandRepository::class,
        \App\Repositories\Contracts\Admin\TagRepositoryInterface::class =>
            \App\Repositories\Eloquent\Admin\TagRepository::class,
        // Vendor Binding
        \App\Repositories\Contracts\Vendor\KycRepositoryInterface::class => \App\Repositories\Eloquent\Vendor\KycRepository::class,
        \App\Repositories\Contracts\Vendor\ProductRepositoryInterface::class => \App\Repositories\Eloquent\Vendor\ProductRepository::class,
        \App\Repositories\Contracts\Vendor\BrandRepositoryInterface::class =>
            \App\Repositories\Eloquent\Vendor\BrandRepository::class,
        \App\Repositories\Contracts\Vendor\TagRepositoryInterface::class =>
            \App\Repositories\Eloquent\Vendor\TagRepository::class,
        \App\Repositories\Contracts\Vendor\StoreRepositoryInterface::class => \App\Repositories\Eloquent\Vendor\StoreRepository::class,
        \App\Repositories\Contracts\Vendor\CategoryRepositoryInterface::class => \App\Repositories\Eloquent\Vendor\CategoryRepository::class,
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