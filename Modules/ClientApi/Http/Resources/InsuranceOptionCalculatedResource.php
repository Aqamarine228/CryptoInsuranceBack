<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\InsuranceOption;
use Modules\ClientApi\Models\InsuranceSubscriptionOption;

/**
 * class InsuranceOptionResource
 *
 * @mixin InsuranceOption
 */
class InsuranceOptionCalculatedResource extends JsonResource
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
            'description' => $this->description,
            'price' => (float)$this->subscriptionOption->calculateEndPrice($this->price),
            'currency' => $this->currency,
        ];
    }
}
