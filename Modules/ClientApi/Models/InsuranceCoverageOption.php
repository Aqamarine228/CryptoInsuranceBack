<?php

namespace Modules\ClientApi\Models;

class InsuranceCoverageOption extends \App\Models\InsuranceCoverageOption
{

    /**
     * Methods
     */

    public function addToPrice(float $price): float
    {
        $additionalPrice = bcmul($price, bcdiv($this->price_percentage, "100", 2), 5);
        return bcadd($price, $additionalPrice, 5);
    }
}
