<?php

namespace Modules\ClientApi\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class InsuranceOption extends \App\Models\InsuranceOption
{
    use Searchable;

    protected array $localizable = ['name', 'description'];

    protected bool $hideLocaleSpecificAttributes = false;

    public function toSearchableArray(): array
    {
        return [
            'name_en' => $this->name_en,
            'name_ru' => $this->name_ru,
        ];
    }

    /**
     * Relations
     */

    public function fields(): HasMany
    {
        return $this->hasMany(InsuranceOptionField::class);
    }
}
