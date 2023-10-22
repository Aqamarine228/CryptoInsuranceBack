<?php

namespace Modules\ClientApi\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Insurance extends \App\Models\Insurance
{
    protected $fillable = [
        'user_id',
        'expires_at',
        'coverage',
        'max_wallets_count',
        'exchange_id',
        'exchange_name',
        'paid',
    ];

    /**
     * Scopes
     */

    public function scopeActive(Builder $query): void
    {
        $query->where('paid', true)->whereDate('expires_at', '>', now());
    }

    /**
     * Relations
     */

    public function wallets(): HasMany
    {
        return $this->hasMany(InsuranceWallet::class);
    }

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(InsuranceOption::class);
    }
}
