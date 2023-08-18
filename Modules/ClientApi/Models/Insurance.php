<?php

namespace Modules\ClientApi\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Insurance extends \App\Models\Insurance
{

    /**
     * Scopes
     */

    public function scopeActive(Builder $query): void
    {
        $query->whereDate('expires_at', '>', now());
    }

    /**
     * Relations
     */

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(InsuranceOption::class);
    }
}
