<?php

namespace App\Providers;

use App\Facades\Payments\CoinbasePayments;
use App\Facades\Payments\ShkeeperPayments;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
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
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        Paginator::useBootstrapFour();
        $this->app->singleton(ShkeeperPayments::class, function () {
            return new ShkeeperPayments();
        });
        $this->app->singleton(CoinbasePayments::class, function () {
            return new CoinbasePayments();
        });
    }
}
