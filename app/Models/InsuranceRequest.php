<?php

namespace App\Models;

use App\Enums\InsuranceRequestStatus;
use Illuminate\Database\Eloquent\Model;

class InsuranceRequest extends Model
{

    protected $casts = [
        'status' => InsuranceRequestStatus::class,
    ];
}
