<?php

namespace Modules\ClientApi\Models;

use App\Enums\Currency;
use App\Models\Payable;
use DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class InsuranceInvoice extends \App\Models\InsuranceInvoice implements Payable
{

    protected $fillable = [
        'amount',
        'currency',
        'user_id',
        'insurance_subscription_option_id',
    ];

    public function getPrice(): float
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function paid(): void
    {
        DB::transaction(function () {
            $insurance = Insurance::create([
                'user_id' => $this->user_id,
                'expires_at' => now()->addSeconds($this->subscriptionOption->duration),
            ]);
            $insurance->options()->sync($this->options->pluck('id'));
            $user = $this->user;
            if ($user->hasReferral()) {
                $this->referralIncome()->create([
                    'amount' => bcmul($this->amount, bcdiv(config('referrals.income_percent'), "100", 2), 2),
                    'user_id' => $user->inviter_id,
                    'referral_id' => $user->id,
                    'currency' => $this->currency,
                ]);
            }
        });
    }

    /**
     * Relations
     */

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(InsuranceOption::class);
    }

    public function subscriptionOption(): BelongsTo
    {
        return $this->belongsTo(InsuranceSubscriptionOption::class, 'insurance_subscription_option_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function referralIncome(): MorphOne
    {
        return $this->morphOne(ReferralIncome::class, 'payable');
    }
}
