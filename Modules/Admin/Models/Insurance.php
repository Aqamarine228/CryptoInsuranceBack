<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Builder;

class Insurance extends \App\Models\Insurance
{

    /**
     * Scopes
     */

    public function scopeActive(Builder $query): void
    {
        $query->whereDate('expires_at', '>', now());
    }
}
