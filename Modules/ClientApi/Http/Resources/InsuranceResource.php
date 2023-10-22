<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\Insurance;

/**
 * class InsuranceResource
 *
 * @mixin Insurance
 */
class InsuranceResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'expires_at' => $this->expires_at,
            'options' => InsuranceOptionResource::collection($this->whenLoaded('options')),
            'wallets' => InsuranceWalletResource::collection($this->whenLoaded('wallets')),
            'exchange_id' => $this->exchange_id,
            'exchange_name' => $this->exchange_name,
            'coverage' => $this->coverage,
            'created_at' => $this->created_at,
            'max_wallets_count' => $this->max_wallets_count,
        ];
    }

}
