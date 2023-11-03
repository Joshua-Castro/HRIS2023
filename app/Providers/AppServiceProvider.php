<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LogService;
use App\Services\ManualCascadeDeleteService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ManualCascadeDeleteService::class, function ($app) {
            return new ManualCascadeDeleteService();
        });

        $this->app->singleton(LogService::class, function ($app) {
            return new LogService();
        });

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
