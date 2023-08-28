<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsuranceSubscriptionOption extends Model
{
    use SoftDeletes;

    protected $casts = [
        'sale_percentage' => 'decimal:2',
    ];
}
