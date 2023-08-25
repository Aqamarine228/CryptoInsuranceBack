<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\ClientApi\Http\Resources\InsuranceOptionResource;
use Modules\ClientApi\Models\InsuranceOption;

class InsuranceOptionController extends BaseClientApiController
{

    public function paginate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'search' => 'string|max:255',
        ]);

        if (array_key_exists('search', $validated)) {
            $insuranceOptions = InsuranceOption::search($validated['search'])->paginate();
        } else {
            $insuranceOptions = InsuranceOption::paginate();
        }

        return $this->respondSuccess(InsuranceOptionResource::collection($insuranceOptions)->response()->getData(true));
    }
}
