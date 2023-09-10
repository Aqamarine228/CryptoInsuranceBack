<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\ClientApi\Http\Resources\InsuranceSubscriptionOptionResource;
use Modules\ClientApi\Models\InsuranceSubscriptionOption;

class InsuranceSubscriptionOptionController extends BaseClientApiController
{
    public function index(): JsonResponse
    {
        return $this->respondSuccess(InsuranceSubscriptionOptionResource::collection(InsuranceSubscriptionOption::all()));
    }

}
