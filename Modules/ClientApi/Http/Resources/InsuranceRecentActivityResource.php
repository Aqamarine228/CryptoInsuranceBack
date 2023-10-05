<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\InsuranceRequest;

/**
 * class InsuranceRecentActivityResource
 *
 * @mixin InsuranceRequest
 */
class InsuranceRecentActivityResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'insurance_option' => new InsuranceOptionResource($this->option),
            'created_at' => $this->created_at,
            'coverage' => $this->coverage,
        ];
    }
}
