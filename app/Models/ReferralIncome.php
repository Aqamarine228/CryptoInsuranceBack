<?php

namespace App\Models;

use App\Enums\Currency;
use Illuminate\Database\Eloquent\Model;

class ReferralIncome extends Model
{
    protected $casts = [
        'currency' => Currency::class,
        'amount' => 'float'
    ];

}
