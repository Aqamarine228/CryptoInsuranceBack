<?php

namespace App\Models;

use App\Enums\Currency;
use Illuminate\Database\Eloquent\Model;

class InsuranceInvoice extends Model
{
    protected $casts = [
        'currency' => Currency::class,
    ];
}
