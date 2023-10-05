<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\InsuranceCoverageOption;

/**
 * class InsuranceCoverageOptionResource
 *
 * @mixin InsuranceCoverageOption
 */
class InsuranceCoverageOptionResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'price_percentage' => $this->price_percentage,
            'coverage' => $this->coverage,
        ];
    }
}
