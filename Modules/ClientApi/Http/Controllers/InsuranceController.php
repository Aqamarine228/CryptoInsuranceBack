<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ClientApi\Http\Resources\InsuranceRecentActivityResource;
use Modules\ClientApi\Http\Resources\InsuranceResource;
use Modules\ClientApi\Http\Resources\InsuranceStatisticResource;
use Modules\ClientApi\Models\Insurance;
use Modules\ClientApi\Models\InsuranceRequest;

class InsuranceController extends BaseClientApiController
{
    const RECENT_ACTIVITY_PER_PAGE_COUNT = 9;

    public function index(Request $request): JsonResponse
    {
        return $this->respondSuccess(
            InsuranceResource::collection(
                $request->user()->insurances()->active()->with('options.fields')->with('wallets')->get()
            )
        );
    }

    public function show(Insurance $insurance): JsonResponse
    {
        $insurance->load('options');
        return $this->respondSuccess(new InsuranceResource($insurance));
    }

    public function showWithInformation(Insurance $insurance): JsonResponse
    {
        return $this->respondSuccess(new InsuranceResource($insurance));
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
