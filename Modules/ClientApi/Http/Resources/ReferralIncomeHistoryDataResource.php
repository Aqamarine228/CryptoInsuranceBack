<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\ReferralIncome;

/**
 * class ReferralIncomeHistoryDataResource
 *
 * @mixin ReferralIncome
 */
class ReferralIncomeHistoryDataResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'x' => $this->day,
            'y' => $this->amount,
        ];
    }

}
