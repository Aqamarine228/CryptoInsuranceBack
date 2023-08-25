<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceSubscriptionOption extends Model
{

    protected $casts = [
        'sale_percentage' => 'decimal:2',
    ];
}
