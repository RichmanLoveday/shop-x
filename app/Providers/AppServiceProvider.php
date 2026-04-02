<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Kyc;
use App\Services\Contracts\Admin\SettingsServiceInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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

        Paginator::useBootstrapFive();
    }
}
