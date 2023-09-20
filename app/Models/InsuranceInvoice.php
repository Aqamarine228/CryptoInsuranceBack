<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\InsuranceInvoiceStatus;
use Illuminate\Database\Eloquent\Model;

class InsuranceInvoice extends Model
{
    protected $casts = [
        'currency' => Currency::class,
        'status' => InsuranceInvoiceStatus::class,
    ];
}
