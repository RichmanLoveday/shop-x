<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Kyc;
use App\Services\Contracts\Admin\SettingsServiceInterface;
use App\Services\User\CartService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(SettingsServiceInterface $settingsService): void
    {
        // supper admin has all permissions
        Gate::before(function ($admin, $ability) {
            return $admin->hasRole('super_admin') ? true : null;
        });

        // Load application settings into config() on every request
        $settingsService->setSettings();

        View::composer('*', function ($view) {
            $count = 0;

            if (auth()->check()) {
                $count = app(CartService::class)
                    ->getCartCount(auth()->user());
            }

            $view->with('cartCount', $count);
        });

        Paginator::useBootstrapFive();
    }
}