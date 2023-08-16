<?php

namespace App\Models;

use App\Enums\InsuranceOptionFieldType;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsuranceOptionField extends LocalizableModel
{
    use SoftDeletes;

    protected $casts = [
        'type' => InsuranceOptionFieldType::class,
        'required' => 'boolean',
    ];
}
