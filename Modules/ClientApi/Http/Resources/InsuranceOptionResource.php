<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\InsuranceOption;
use Modules\ClientApi\Models\InsuranceSubscriptionOption;

/**
 * class InsuranceOptionResource
 *
 * @mixin InsuranceOption
 */
class InsuranceOptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'fields' => $this->when('fields', InsuranceOptionFieldResource::collection($this->fields)),
        ];
    }
}
