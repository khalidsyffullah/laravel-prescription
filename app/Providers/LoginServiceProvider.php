<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LoginService;


class LoginServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(LoginService::class, function ($app) {
            return new LoginService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
