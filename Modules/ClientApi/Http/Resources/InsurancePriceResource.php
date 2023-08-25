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
        $price = bcmul($this->price, bcdiv($this->sale_percentage, "100", 2), 2);
        return [
            'subscription_option_id' => $this->id,
            'price' => $price,
            'duration' => $this->duration,
        ];
    }
}
