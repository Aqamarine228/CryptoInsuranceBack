<?php

namespace Modules\ClientApi\Models;

use App\Models\FilterableByColumn;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\ClientApi\Notifications\VerifyEmailNotification;

class User extends \App\Models\User
{
    use FilterableByColumn;

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'inviter_id',
        'locale',
        'balance',
    ];

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification);
    }

    /**
     * Methods
     */

    public function hasReferral(): bool
    {
        return (bool)$this->inviter_id;
    }

    /**
     * Relations
     */

    public function withdrawalRequests(): HasMany
    {
        return $this->hasMany(WithdrawalRequest::class, 'user_id', 'id');
    }

    public function referralRequests(): HasMany
    {
        return $this->hasMany(ReferralRequest::class, 'user_id', 'id');
    }

    public function insurances(): HasMany
    {
        return $this->hasMany(Insurance::class);
    }

    public function insuranceRequests(): HasMany
    {
        return $this->hasMany(InsuranceRequest::class);
    }

    public function inviter(): BelongsTo
    {
        return $this->belongsTo(self::class, 'inviter_id', 'id');
    }

    public function referralIncome(): HasMany
    {
        return $this->hasMany(ReferralIncome::class, 'user_id');
    }

    public function inviterIncome(): HasMany
    {
        return $this->hasMany(ReferralIncome::class, 'referral_id');
    }

    public function latestInviterIncome(): HasOne
    {
        return $this->hasOne(ReferralIncome::class, 'referral_id')->latestOfMany();
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(self::class, 'inviter_id', 'id');
    }
}
