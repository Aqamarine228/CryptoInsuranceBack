<?php

namespace Modules\ClientApi\Jobs;

use App\Enums\Currency;
use App\Enums\InsuranceInvoiceStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Modules\ClientApi\Models\Insurance;
use Modules\ClientApi\Models\InsuranceCoverageOption;
use Modules\ClientApi\Models\InsuranceInvoice;
use Modules\ClientApi\Models\InsuranceOption;
use Modules\ClientApi\Models\InsuranceSubscriptionOption;
use Modules\ClientApi\Models\User;

class CreateInsuranceInvoice implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $subscriptionOption = InsuranceSubscriptionOption::inRandomOrder()->first();
        if (!$subscriptionOption) {
            return;
        }

        $price = InsuranceOption::inRandomOrder()->limit(mt_rand(3, 20))->sum('price');

        $coverage = InsuranceCoverageOption::inRandomOrder()->first();
        if (!$coverage) {
            return;
        }

        DB::transaction(function () use ($coverage, $subscriptionOption, $price) {
            $user = User::firstOrCreate(config('generators.user'), ['password' => '123']);
            $insurance = Insurance::create([
                'expires_at' => now(),
                'paid' => false,
                'coverage' => $coverage->coverage,
                'exchange_name' => 'none',
                'exchange_id' => 'none',
                'max_wallets_count' => 3,
                'user_id' => $user->id,
            ]);

            InsuranceInvoice::create([
                'amount' => $coverage->addToPrice($subscriptionOption->calculatePrice($price)),
                'insurance_subscription_option_id' => $subscriptionOption->id,
                'insurance_id' => $insurance->id,
                'currency' => Currency::USD->value,
                'status' => InsuranceInvoiceStatus::PAID->value,
                'user_id' => $user->id,
            ]);
        });
    }
}
