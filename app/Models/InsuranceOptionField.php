<?php

namespace App\Models;

use App\Enums\InsuranceOptionFieldType;

class InsuranceOptionField extends LocalizableModel
{
    protected $fillable = [
        'name_en',
        'name_ru',
    ];

    protected $casts = [
        'type' => InsuranceOptionFieldType::class,
    ];
}
