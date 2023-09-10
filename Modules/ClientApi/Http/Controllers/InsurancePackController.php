<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ClientApi\Http\Resources\InsurancePackResource;
use Modules\ClientApi\Models\InsurancePack;
use Modules\ClientApi\Models\InsuranceSubscriptionOption;

class InsurancePackController extends BaseClientApiController
{
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'insurance_subscription_option_id' => 'required|exists:insurance_subscription_options,id',
        ]);
        $subscriptionOption = InsuranceSubscriptionOption::find($validated['insurance_subscription_option_id']);
        return $this->respondSuccess(
            InsurancePack::all()->map(
                fn(InsurancePack $insurancePack) => new InsurancePackResource($insurancePack, $subscriptionOption)
            )
        );
    }

}
