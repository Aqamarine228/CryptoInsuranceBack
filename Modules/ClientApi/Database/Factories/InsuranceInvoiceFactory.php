<?php

namespace Modules\ClientApi\Database\Factories;

use App\Enums\Currency;
use App\Enums\InsuranceInvoiceStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ClientApi\Models\InsuranceInvoice;

class InsuranceInvoiceFactory extends Factory
{
    protected $model = InsuranceInvoice::class;

    public function definition(): array
    {
        return [
            'status' => InsuranceInvoiceStatus::UNPAID->value,
            'amount' => $this->faker->randomNumber(3),
            'currency' => Currency::USD->value,
            'insurance_subscription_option_id' => InsuranceSubscriptionOptionFactory::new()->create()->id,
            'coverage' => $this->faker->randomNumber(9, false),
            'user_id' => UserFactory::new()->create()->id,
        ];
    }
}
