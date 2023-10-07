<?php

namespace Modules\ClientApi\Models;

use App\Enums\WithdrawalRequestStatus;
use App\Models\FilterableByColumn;
use App\Models\FilterableByTimePeriod;

class WithdrawalRequest extends \App\Models\WithdrawalRequest
{
    use FilterableByTimePeriod, FilterableByColumn;

    protected $fillable = [
        'amount', 'crypto_amount', 'cryptocurrency', 'currency', 'status', 'user_id', 'address',
    ];

    /**
     * Scopes
     */

    public function scopePaid($q)
    {
        return $q->where('status', WithdrawalRequestStatus::PAID);
    }
}
