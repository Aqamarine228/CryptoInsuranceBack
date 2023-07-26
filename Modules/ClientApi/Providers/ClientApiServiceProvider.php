<?php

namespace Modules\ClientApi\Providers;

use Illuminate\Support\ServiceProvider;

class ClientApiServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'ClientApi';

    protected string $moduleNameLower = 'clientapi';

    public function boot(): void
    {
        $this->registerConfig();
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }

    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'),
            $this->moduleNameLower
        );
    }


    public function provides(): array
    {
        return [];
    }
}