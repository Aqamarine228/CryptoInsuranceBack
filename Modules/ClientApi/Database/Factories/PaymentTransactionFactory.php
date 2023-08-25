<?php

namespace Modules\ClientApi\Database\Factories;

use App\Enums\Cryptocurrency;
use App\Enums\PaymentTransactionStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ClientApi\Models\InsuranceInvoice;
use Modules\ClientApi\Models\PaymentTransaction;

class PaymentTransactionFactory extends Factory
{

    protected $model = PaymentTransaction::class;

    public function definition(): array
    {
        return [
            'uuid' => \Str::uuid(),
            'user_id' => UserFactory::new()->create()->id,
            'payable_type' => InsuranceInvoice::class,
            'payable_id' => InsuranceInvoiceFactory::new()->create()->id,
            'currency' => Cryptocurrency::BTC,
            'amount' => $this->faker->randomNumber(3),
            'status' => PaymentTransactionStatus::UNPAID,
        ];
    }
}
