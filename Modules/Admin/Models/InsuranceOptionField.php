<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsuranceOptionField extends \App\Models\InsuranceOptionField
{
    use SoftDeletes;

    protected $fillable = [
        'name_en',
        'name_ru',
        'type',
        'required',
        'slug',
    ];

    /**
     * Relations
     */

    public function fields(): HasMany
    {
        return $this->hasMany(InsuranceOptionField::class);
    }
}
