<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class InsurancePack extends LocalizableModel
{
    use SoftDeletes;

    protected array $localizable = ['name_ru', 'name_en', 'description_ru', 'description_en'];
}
