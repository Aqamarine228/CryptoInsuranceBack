<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends BaseClientApiController
{
    public function __invoke(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->respondSuccess();
    }
}
