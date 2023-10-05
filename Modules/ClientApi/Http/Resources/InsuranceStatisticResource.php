<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\InsuranceRequest;

class InsuranceStatisticResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'insurance_fund' => 100000,
            'total_insurance_paid' => InsuranceRequest::approved()
                ->sum('coverage'),
            'insurance_paid_today' => InsuranceRequest::approved()
                ->whereDate('created_at', today())
                ->sum('coverage'),
        ];
    }
}
