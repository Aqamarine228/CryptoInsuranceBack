<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\InsuranceSubscriptionOption;

/**
 * class InsuranceSubscriptionOptionResource
 *
 * @mixin InsuranceSubscriptionOption
 */
class InsuranceSubscriptionOptionResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'duration' => $this->duration,
            'sale_percentage' => (float)$this->sale_percentage,
        ];
    }

}
