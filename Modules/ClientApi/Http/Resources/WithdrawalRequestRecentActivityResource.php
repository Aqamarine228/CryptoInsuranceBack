<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\WithdrawalRequest;

/**
 * class WithdrawalRequestRecentActivityResource
 *
 * @mixin WithdrawalRequest
 */
class WithdrawalRequestRecentActivityResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'amount' => (float)$this->amount,
            'crypto_amount' => (float)$this->crypto_amount,
            'cryptocurrency' => $this->cryptocurrency->value,
            'crated_at' => $this->created_at,
            'type' => 'withdrawal',
        ];
    }

}
