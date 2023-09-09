<?php

namespace App\Http\Middleware;

use Aqamarine\RestApiResponses\Controllers\ApiResponses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    use ApiResponses;
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasHeader("Accept-Language") && !locale()->isSupported($request->header("Accept-Language"))) {
            return $this->respondErrorMessage("Bad locale", 400);
        }

        if ($request->hasHeader("Accept-Language")) {
            locale()->set($request->header("Accept-Language"));
        }

        return $next($request);
    }
}
