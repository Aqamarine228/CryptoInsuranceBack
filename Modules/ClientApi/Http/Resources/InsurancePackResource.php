<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\InsurancePack;
use Modules\ClientApi\Models\InsuranceSubscriptionOption;

/**
 * class InsurancePackResource
 *
 * @mixin InsurancePack
 */
class InsurancePackResource extends JsonResource
{
    public function __construct($resource, private InsuranceSubscriptionOption $subscriptionOption)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->subscriptionOption->calculatePrice($this->price),
            'description' => $this->description,
            'options' => InsuranceOptionResource::collection($this->options),
            'coverage' => $this->coverage,
        ];
    }

}
