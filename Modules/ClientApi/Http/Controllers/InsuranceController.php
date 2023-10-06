<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ClientApi\Http\Resources\InsurancePriceResource;
use Modules\ClientApi\Http\Resources\InsuranceRecentActivityResource;
use Modules\ClientApi\Http\Resources\InsuranceResource;
use Modules\ClientApi\Http\Resources\InsuranceStatisticResource;
use Modules\ClientApi\Models\InsuranceOption;
use Modules\ClientApi\Models\InsuranceRequest;
use Modules\ClientApi\Models\InsuranceSubscriptionOption;

class InsuranceController extends BaseClientApiController
{
    const RECENT_ACTIVITY_PER_PAGE_COUNT = 9;

    public function show(Request $request): JsonResponse
    {
        $insurance = $request->user()->insurances()->active()->first();
        return $this->respondSuccess(
            $insurance ? new InsuranceResource($insurance) : null
        );
    }

    public function statistic(): JsonResponse
    {
        return $this->respondSuccess(new InsuranceStatisticResource([]));
    }

    public function recentActivity(): JsonResponse
    {
        return $this->respondSuccess(
            InsuranceRecentActivityResource::collection(
                InsuranceRequest::approved()
                    ->with('option')
                    ->latest()
                    ->limit(self::RECENT_ACTIVITY_PER_PAGE_COUNT)
                    ->get()
            )
        );
    }
}
