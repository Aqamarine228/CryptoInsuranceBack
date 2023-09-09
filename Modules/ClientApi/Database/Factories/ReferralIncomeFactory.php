<?php

namespace Modules\ClientApi\Database\Factories;

use App\Enums\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ClientApi\Models\InsuranceInvoice;
use Modules\ClientApi\Models\ReferralIncome;

class ReferralIncomeFactory extends Factory
{
    protected $model = ReferralIncome::class;

    public function definition(): array
    {
        return [
            'user_id' => UserFactory::new()->create()->id,
            'referral_id' => UserFactory::new()->create()->id,
            'amount' => $this->faker->randomNumber(5, false),
            'currency' => Currency::USD->value,
            'payable_type' => InsuranceInvoice::class,
            'payable_id' => InsuranceFactory::new()->create()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
