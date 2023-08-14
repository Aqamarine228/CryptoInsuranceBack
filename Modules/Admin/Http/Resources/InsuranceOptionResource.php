<?php

namespace Modules\Admin\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\InsuranceOption;

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
            'name' => $this->name_en,
        ];
    }
}
