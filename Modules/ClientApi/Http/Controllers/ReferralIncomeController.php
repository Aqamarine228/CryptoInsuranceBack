<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ClientApi\Http\Resources\ReferralIncomeResource;

class ReferralIncomeController extends BaseClientApiController
{

    public function index(Request $request): JsonResponse
    {
        return $this->respondSuccess(
            ReferralIncomeResource::collection($request->user()->referralIncome()->paginate())
                ->response()
                ->getData(true)
        );
    }

}
