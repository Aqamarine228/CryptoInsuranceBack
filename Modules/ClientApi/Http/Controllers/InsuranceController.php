<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ClientApi\Http\Resources\InsurancePriceResource;
use Modules\ClientApi\Models\InsuranceOption;
use Modules\ClientApi\Models\InsuranceSubscriptionOption;

class InsuranceController extends BaseClientApiController
{

    public function calculatePrice(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'insurance_options' => 'required|array',
            'insurance_options.*' => 'required|exists:insurance_options,id',
        ]);

        $price = InsuranceOption::whereIn('id', $validated['insurance_options'])->sum('price');

        return $this->respondSuccess(InsurancePriceResource::collection(
            InsuranceSubscriptionOption::all()->map(
                fn (InsuranceSubscriptionOption $option) => new InsurancePriceResource($option, $price)
            )
        ));
    }
}
