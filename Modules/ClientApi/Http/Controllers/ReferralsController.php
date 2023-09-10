<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ClientApi\Http\Resources\ReferralResource;

class ReferralsController extends BaseClientApiController
{

    public function index(Request $request): JsonResponse
    {
        return $this->respondSuccess(
            ReferralResource::collection($request->user()->referrals()->paginate())->response()->getData(true)
        );
    }

    public function widgetsData(Request $request): JsonResponse
    {
        return $this->respondSuccess([
            'count' => $request->user()->referrals()->count(),
            'income_overall' => (float)$request->user()->referralIncome()->sum('amount'),
            'count_new_today' => $request->user()->referrals()->whereDate('created_at', today())->count(),
            'income_today' => $request->user()->referralIncome()->whereDate('created_at', today())->sum('amount'),
        ]);
    }

}
