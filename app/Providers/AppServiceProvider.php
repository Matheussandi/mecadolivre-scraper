<?php

namespace App\Providers;

use App\Models\User;
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
        Gate::define("is-admin", function (User $user): bool {
            return $user->is_admin;
        });

        Gate::define("is-owner", function (User $user, User $register): bool {
            return $user->id === $register->user_id;
        });
    }
}
