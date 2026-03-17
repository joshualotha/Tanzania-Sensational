<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('access-dashboard', function ($user) {
            return in_array($user->role ?? null, ['admin', 'manager'], true);
        });

        Gate::define('manage-settings', function ($user) {
            return ($user->role ?? null) === 'admin';
        });

        Gate::define('manage-users', function ($user) {
            return ($user->role ?? null) === 'admin';
        });
    }
}
