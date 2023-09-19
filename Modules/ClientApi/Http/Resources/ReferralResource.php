<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Modules\ClientApi\Models\User;

/**
 * class ReferralResource
 *
 * @mixin User
 */
class ReferralResource extends \Illuminate\Http\Resources\Json\JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->first_name,
            'income' => (float)$this->inviter_income_sum_amount,
            'last_income' => $this->latestInviterIncome?->created_at,
        ];
    }
}
