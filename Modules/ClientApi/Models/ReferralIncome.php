<?php

namespace Modules\ClientApi\Models;

use App\Models\FilterableByColumn;
use App\Models\FilterableByTimePeriod;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ReferralIncome extends \App\Models\ReferralIncome
{
    use FilterableByTimePeriod, FilterableByColumn;

    protected $fillable = [
        'amount',
        'currency',
        'user_id',
        'referral_id',
        'payable_type',
        'payable_id',
    ];

    /**
     * Relations
     */

    public function payable(): MorphTo
    {
        return $this->morphTo();
    }

    public function referral(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
