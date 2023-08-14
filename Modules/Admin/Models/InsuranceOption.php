<?php

namespace Modules\Admin\Models;

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
}
