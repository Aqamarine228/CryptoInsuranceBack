<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ClientApi\Http\Resources\UserResource;

class UserController extends BaseClientApiController
{

    public function show(Request $request): JsonResponse
    {
        return $this->respondSuccess(new UserResource($request->user()));
    }
}
