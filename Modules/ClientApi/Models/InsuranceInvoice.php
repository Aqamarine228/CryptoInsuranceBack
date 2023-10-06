<?php

namespace Modules\ClientApi\Models;

use App\Enums\Currency;
use App\Enums\InsuranceInvoiceStatus;
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
        'coverage',
        'status',
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
                'coverage' => $this->coverage,
            ]);
            $insurance->options()->sync($this->options->pluck('id'));
            $this->update(['status' => InsuranceInvoiceStatus::PAID]);
            $user = $this->user;
            if ($user->hasReferral()) {
                $incomeAmount = bcmul($this->amount, bcdiv(config('referrals.income_percent'), "100", 2), 2);
                $this->referralIncome()->create([
                    'amount' => $incomeAmount,
                    'user_id' => $user->inviter_id,
                    'referral_id' => $user->id,
                    'currency' => $this->currency,
                ]);
                $user->inviter->update([
                    'balance' => bcadd($user->inviter->balance, $incomeAmount, 2),
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
