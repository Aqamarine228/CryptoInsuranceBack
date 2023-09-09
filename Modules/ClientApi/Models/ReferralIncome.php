<?php

namespace Modules\ClientApi\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;

class ReferralIncome extends \App\Models\ReferralIncome
{
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
}
