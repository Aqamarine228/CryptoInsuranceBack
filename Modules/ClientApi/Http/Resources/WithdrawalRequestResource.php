<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\WithdrawalRequest;

/**
 * class WithdrawalRequestResource
 *
 * @mixin WithdrawalRequest
 */
class WithdrawalRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => (float)$this->amount,
            'crypto_amount' => (float)$this->crypto_amount,
            'cryptocurrency' => $this->cryptocurrency,
            'status' => $this->status->value,
            'created_at' => $this->created_at,
        ];
    }
}
