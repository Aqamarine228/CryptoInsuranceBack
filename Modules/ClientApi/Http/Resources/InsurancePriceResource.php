<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\InsuranceSubscriptionOption;

/**
 * class InsurancePriceResource
 *
 * @mixin InsuranceSubscriptionOption
 */
class InsurancePriceResource extends JsonResource
{
    public function __construct($resource, private readonly float $price)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            'subscription_option_id' => $this->id,
            'price' => $this->calculatePrice($this->price),
            'duration' => $this->duration,
        ];
    }
}
