<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\InsuranceRequest;
use Modules\ClientApi\Models\WidgetVariable;

class InsuranceStatisticResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'insurance_fund' => WidgetVariable::getInsuranceFund()->value,
            'total_insurance_paid' => WidgetVariable::getTotalInsurancePaid()->value + InsuranceRequest::approved()
                ->sum('coverage'),
            'insurance_paid_today' => WidgetVariable::getInsurancePaidToday()->value + InsuranceRequest::approved()
                ->whereDate('created_at', today())
                ->sum('coverage'),
        ];
    }
}
