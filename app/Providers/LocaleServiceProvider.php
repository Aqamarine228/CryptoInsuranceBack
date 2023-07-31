<?php

namespace App\Providers;

use App\Components\Locale;
use Illuminate\Support\ServiceProvider;

class LocaleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Locale::class, function ($app) {
            return new Locale($app);
        });
    }
}
