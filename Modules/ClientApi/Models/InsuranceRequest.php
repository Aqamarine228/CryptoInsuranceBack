<?php

namespace Modules\ClientApi\Models;

use App\Enums\InsuranceRequestStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InsuranceRequest extends \App\Models\InsuranceRequest
{

    protected $fillable = [
        'insurance_option_id',
        'coverage',
    ];

    /**
     * Scopes
     */

    public function scopePending($q)
    {
        return $q->where('status', InsuranceRequestStatus::PENDING->value);
    }

    public function scopeApproved($q)
    {
        return $q->where('status', InsuranceRequestStatus::APPROVED->value);
    }

    /**
     * Relations
     */

    public function option(): BelongsTo
    {
        return $this->belongsTo(InsuranceOption::class, 'insurance_option_id');
    }

    public function fields(): HasMany
    {
        return $this->hasMany(InsuranceRequestField::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
