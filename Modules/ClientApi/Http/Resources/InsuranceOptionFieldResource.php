<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\InsuranceOptionField;

/**
 * class InsuranceOptionFieldResource
 *
 * @mixin InsuranceOptionField
 */
class InsuranceOptionFieldResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type->value,
            'required' => $this->required,
            'slug' => $this->slug,
        ];
    }
}
