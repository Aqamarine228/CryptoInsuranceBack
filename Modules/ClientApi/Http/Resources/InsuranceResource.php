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
            'expires_at' => $this->expires_at,
            'options' => InsuranceOptionResource::collection($this->options),
            'created_at' => $this->created_at,
        ];
    }

}
