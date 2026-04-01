<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Kyc;
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
    public function boot(): void
    {
        // supper admin has all permissions
        Gate::before(function ($admin, $ability) {
            return $admin->hasRole('super_admin') ? true : null;
        });

        Paginator::useBootstrapFive();
    }
}