<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ClientApi\Http\Resources\InsuranceOptionCalculatedResource;
use Modules\ClientApi\Http\Resources\InsuranceOptionResource;
use Modules\ClientApi\Models\InsuranceCoverageOption;
use Modules\ClientApi\Models\InsuranceOption;
use Modules\ClientApi\Models\InsuranceSubscriptionOption;

class InsuranceOptionController extends BaseClientApiController
{
    public function show(InsuranceOption $insuranceOption): JsonResponse
    {
        $insuranceOption->load('fields');
        return $this->respondSuccess(new InsuranceOptionResource($insuranceOption));
    }

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'insurance_subscription_option_id' => 'required|exists:insurance_subscription_options,id',
            'insurance_coverage_option_id' => 'required|exists:insurance_coverage_options,id'
        ]);
        $subscriptionOption = InsuranceSubscriptionOption::find($validated['insurance_subscription_option_id']);
        $coverageOption = InsuranceCoverageOption::find($validated['insurance_coverage_option_id']);

        return $this->respondSuccess(
            InsuranceOption::all()->map(
                fn (InsuranceOption $insuranceOption) => new InsuranceOptionCalculatedResource(
                    $insuranceOption,
                    $subscriptionOption,
                    $coverageOption
                )
            )
        );
    }
}
