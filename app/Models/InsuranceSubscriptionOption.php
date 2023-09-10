<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsuranceSubscriptionOption extends Model
{
    use SoftDeletes;

    const DURATION_ENTITY = 60 * 60 * 24;

    protected $casts = [
        'sale_percentage' => 'decimal:2',
    ];
}
