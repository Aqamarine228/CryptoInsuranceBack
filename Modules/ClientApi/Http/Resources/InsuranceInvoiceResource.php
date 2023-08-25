<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\InsuranceInvoice;

/**
 * class InsuranceInvoiceResource
 *
 * @mixin InsuranceInvoice
 */
class InsuranceInvoiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'amount' => (float)$this->amount,
            'currency' => $this->currency,
        ];
    }
}
