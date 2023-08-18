<?php

namespace Modules\ClientApi\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class InsuranceRequest extends \App\Models\InsuranceRequest
{

    protected $fillable = [
        'insurance_option_id'
    ];

    /**
     * Relations
     */

    public function fields(): HasMany
    {
        return $this->hasMany(InsuranceRequestField::class);
    }
}
