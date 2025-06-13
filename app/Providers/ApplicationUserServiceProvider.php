<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use App\Services\ApplicationUserService;
use App\Services\AuthKeysService;
class ApplicationUserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ApplicationUserService::class, function ($app) {
            return new ApplicationUserService();
        });


        $this->app->bind(AuthKeysService::class, function ($app) {
            return new AuthKeysService();
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
