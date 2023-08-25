<?php

namespace App\Providers;

use App\Facades\Payments\Payments;
use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrapFour();
        $this->app->singleton(Payments::class, function () {
            return new Payments();
        });
    }
}
