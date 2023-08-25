<?php

namespace Modules\ClientApi\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InsurancePack extends \App\Models\InsurancePack
{

    /**
     * Relations
     */

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(InsuranceOption::class);
    }
}
