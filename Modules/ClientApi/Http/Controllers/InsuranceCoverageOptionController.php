<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\ClientApi\Http\Resources\InsuranceCoverageOptionResource;
use Modules\ClientApi\Models\InsuranceCoverageOption;

class InsuranceCoverageOptionController extends BaseClientApiController
{

    public function index(): JsonResponse
    {
        return $this->respondSuccess(InsuranceCoverageOptionResource::collection(InsuranceCoverageOption::all()));
    }
}
