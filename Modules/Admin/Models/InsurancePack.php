<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InsurancePack extends \App\Models\InsurancePack
{

    protected bool $hideLocaleSpecificAttributes = false;

    protected bool $appendLocalizedAttributes = true;

    protected $fillable = [
        'name_en',
        'name_ru',
        'description_en',
        'description_ru',
        'slug',
        'price',

    ];

    /**
     * Relations
     */

    public function insuranceOptions(): BelongsToMany
    {
        return $this->belongsToMany(InsuranceOption::class);
    }
}
