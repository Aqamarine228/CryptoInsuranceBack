<?php

namespace App\Models;

use App\Enums\ReferralRequestStatus;

class ReferralRequest extends LocalizableModel
{
    protected $casts = [
        'status' => ReferralRequestStatus::class,
        'approved_at' => 'datetime',
    ];
}
