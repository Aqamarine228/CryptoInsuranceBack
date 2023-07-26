<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected string $moduleNamespace = 'Modules\Admin\Http\Controllers';

    public function map(): void
    {
        $this->mapWebRoutes();
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->prefix('admin')
            ->name('admin.')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Admin', '/Routes/web.php'));
    }
}
