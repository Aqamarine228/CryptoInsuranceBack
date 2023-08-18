<?php

namespace Modules\ClientApi\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class InsuranceOption extends \App\Models\InsuranceOption
{

    /**
     * Relations
     */

    public function fields(): HasMany
    {
        return $this->hasMany(InsuranceOptionField::class);
    }
}
