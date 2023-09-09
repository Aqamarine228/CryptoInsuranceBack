<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\ReferralIncome;

/**
 * class ReferralIncomeResource
 *
 * @mixin ReferralIncome
 */
class ReferralIncomeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency->value,
            'created_at' => $this->created_at,
        ];
    }

}
