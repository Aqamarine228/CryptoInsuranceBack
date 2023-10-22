<?php

namespace App\Models;

use App\Enums\Cryptocurrency;
use Illuminate\Database\Eloquent\Model;

class InsuranceWallet extends Model
{

    protected $casts = [
        'cryptocurrency' => Cryptocurrency::class,
    ];
}
