<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Http\JsonResponse;

class WithdrawalRequestController extends BaseClientApiController
{
    public function create(): JsonResponse
    {
        return $this->respondSuccess("Withdrawal Request Created Successfully");
    }
}
