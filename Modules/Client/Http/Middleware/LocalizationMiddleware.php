<?php

namespace Modules\Client\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class LocalizationMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        $desiredLocale = $request->segment(1);
        $locale = locale()->isSupported($desiredLocale) ? $desiredLocale : locale()->fallback();
        locale()->set($locale);

        URL::defaults(['locale' => $request->segment(1)]);

        return $next($request);
    }
}
