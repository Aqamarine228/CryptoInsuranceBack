<?php

namespace Modules\ClientApi\Models;

use App\Enums\InsuranceRequestStatus;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InsuranceRequest extends \App\Models\InsuranceRequest
{

    protected $fillable = [
        'insurance_option_id'
    ];

    /**
     * Scopes
     */

    public function scopePending($q)
    {
        return $q->where('status', InsuranceRequestStatus::PENDING->value);
    }

    /**
     * Relations
     */

    public function fields(): HasMany
    {
        return $this->hasMany(InsuranceRequestField::class);
    }
}
