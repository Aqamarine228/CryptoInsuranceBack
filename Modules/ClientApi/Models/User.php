<?php

namespace Modules\ClientApi\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\ClientApi\Notifications\VerifyEmailNotification;

class User extends \App\Models\User
{

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'inviter_id',
        'locale',
    ];

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification);
    }

    /**
     * Relations
     */

    public function referralRequests(): HasMany
    {
        return $this->hasMany(ReferralRequest::class);
    }

    public function insurances(): HasMany
    {
        return $this->hasMany(Insurance::class);
    }

    public function insuranceRequests(): HasMany
    {
        return $this->hasMany(InsuranceRequest::class);
    }
}
