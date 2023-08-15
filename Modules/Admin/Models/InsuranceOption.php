<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class InsuranceOption extends \App\Models\InsuranceOption
{
    use Searchable;

    protected bool $hideLocaleSpecificAttributes = false;

    protected bool $appendLocalizedAttributes = true;

    protected array $localizable = [];

    protected $fillable = [
        'name_en',
        'name_ru',
        'description_en',
        'description_ru',
        'slug',
        'price',
        'currency',
    ];

    public function searchableAs(): string
    {
        return 'name_en';
    }

    /**
     * Relations
     */

    public function fields(): HasMany
    {
        return $this->hasMany(InsuranceOptionField::class);
    }
}
