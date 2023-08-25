<?php

namespace Modules\ClientApi\Http\Middleware;

use Aqamarine\RestApiResponses\Controllers\ApiResponses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShkeeperMiddleware
{
    use ApiResponses;

    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasHeader('X-Shkeeper-API-Key')
            || $request->header('X-Shkeeper-API-Key') != config('services.shkeeper.api_key')
        ) {
            return $this->respondErrorMessage('Invalid API key', Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
