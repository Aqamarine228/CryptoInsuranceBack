<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\InsuranceInvoice;

/**
 * class InsuranceInvoiceRecentActivityResource
 *
 * @mixin InsuranceInvoice
 */
class InsuranceInvoiceRecentActivityResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'amount' => (float)$this->amount,
            'coverage' => (float)$this->coverage,
            'type' => 'insurance_invoice',
        ];
    }
}
