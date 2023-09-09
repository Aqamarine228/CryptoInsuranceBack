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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'income' => $this->inviterIncome()->sum('amount'),
            'created_at' => $this->created_at,
        ];
    }
}
