<?php

namespace App\Models;

use App\Enums\Cryptocurrency;
use App\Enums\WithdrawalRequestStatus;
use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{

    protected $casts = [
        'status' => WithdrawalRequestStatus::class,
        'cryptocurrency' => Cryptocurrency::class,
    ];
}
