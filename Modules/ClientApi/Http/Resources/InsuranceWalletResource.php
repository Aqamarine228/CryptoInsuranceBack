<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\InsuranceWallet;

/**
 * class InsuranceWalletResource
 *
 * @mixin InsuranceWallet
 */
class InsuranceWalletResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'cryptocurrency' => $this->cryptocurrency,
            'value' => $this->value,
        ];
    }
}
