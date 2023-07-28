<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class User extends \App\Models\User
{

    protected $fillable = [
        'referral_id',
    ];


    /**
     * Methods
     */

    public function createReferralId(): void
    {
        $this->update(['referral_id' => Str::uuid()]);
    }

    /**
     * Relations
     */

    public function referralRequests(): HasMany
    {
        return $this->hasMany(ReferralRequest::class);
    }
}
