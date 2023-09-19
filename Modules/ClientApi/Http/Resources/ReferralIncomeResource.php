<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\InsuranceInvoice;
use Modules\ClientApi\Models\ReferralIncome;
use RuntimeException;

/**
 * class ReferralIncomeResource
 *
 * @mixin ReferralIncome
 */
class ReferralIncomeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->getIncomeType($this->payable_type),
            'amount' => $this->amount,
            'currency' => $this->currency->value,
            'created_at' => $this->created_at,
        ];
    }

    public function getIncomeType($payableType): string
    {
        return match($payableType) {
            InsuranceInvoice::class => __("referralIncomeType.insurance"),
            default => throw new RuntimeException('Not supported payable type'),
        };
    }

}
