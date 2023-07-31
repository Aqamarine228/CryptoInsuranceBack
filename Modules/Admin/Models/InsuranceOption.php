<?php

namespace Modules\Admin\Models;

class InsuranceOption extends \App\Models\InsuranceOption
{
    protected bool $hideLocaleSpecificAttributes = false;

    protected bool $appendLocalizedAttributes = false;

    protected $fillable = [
        'name_en',
        'name_ru',
        'slug',
        'price',
        'currency',
    ];
}
