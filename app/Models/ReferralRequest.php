<?php

namespace App\Models;

use App\Enums\ReferralRequestStatus;
use Illuminate\Database\Eloquent\Model;

class ReferralRequest extends Model
{
    protected $casts = [
        'status' => ReferralRequestStatus::class,
        'approved_at' => 'datetime',
    ];
}
