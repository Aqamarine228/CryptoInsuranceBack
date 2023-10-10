<?php

namespace Modules\ClientApi\Models;

class InsuranceSubscriptionOption extends \App\Models\InsuranceSubscriptionOption
{

    /**
     * Methods
     */

    public function calculatePrice(float $price): float
    {
        $entities = bcdiv($this->duration, self::DURATION_ENTITY, 2);
        $priceWithEntities = bcmul($price, $entities, 2);
        if ($this->sale_percentage == 0) {
            $sale = 0;
        } else {
            $sale = bcmul($priceWithEntities, bcdiv($this->sale_percentage, "100", 2), 2);
        }
        return bcsub($priceWithEntities, $sale, 2);
    }
}
