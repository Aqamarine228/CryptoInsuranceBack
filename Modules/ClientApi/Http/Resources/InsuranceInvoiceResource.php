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
            'status' => $this->status->value,
            'currency' => $this->currency,
            'created_at' => $this->created_at,
        ];
    }
}
