<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class InsuranceOption extends LocalizableModel
{
    use SoftDeletes;

    protected array $localizable = ['name', 'description'];
}
