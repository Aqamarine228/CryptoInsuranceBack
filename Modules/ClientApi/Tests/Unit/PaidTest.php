<?php

namespace Modules\ClientApi\Tests\Unit;

use App\Enums\InsuranceInvoiceStatus;
use Modules\ClientApi\Database\Factories\InsuranceFactory;
use Modules\ClientApi\Database\Factories\InsuranceInvoiceFactory;
use Modules\ClientApi\Database\Factories\PaymentTransactionFactory;
use Modules\ClientApi\Database\Factories\UserFactory;
use Modules\ClientApi\Models\InsuranceInvoice;
use Modules\ClientApi\Tests\ClientApiTestCase;

class PaidTest extends ClientApiTestCase
{
    public function testPaymentConfirmed(): void
    {
        $referral = UserFactory::new()->create();

        $this->user->update([
            'inviter_id' => $referral->id,
        ]);

        $insurance = InsuranceFactory::new()->state([
            'user_id' => $this->user->id,
        ])->create();

        $insuranceInvoice = InsuranceInvoiceFactory::new()->state([
            'user_id' => $this->user->id,
            'insurance_id' => $insurance->id,
        ])->create();

        $paymentTransaction = PaymentTransactionFactory::new()->state([
            'payable_id' => $insuranceInvoice->id,
            'payable_type' => InsuranceInvoice::class,
            'user_id' => $this->user->id,
        ])->create();

        $paymentTransaction->payable->paid();
        $insuranceInvoice = $insuranceInvoice->fresh();

        $this->assertEquals(InsuranceInvoiceStatus::PAID, $insuranceInvoice->status);

        $this->assertDatabaseHas('insurances', [
            'user_id' => $insuranceInvoice->user_id,
            'expires_at' => now()->addSeconds($insuranceInvoice->subscriptionOption->duration)
        ]);
        $referralIncome = bcmul(
            $insuranceInvoice->amount,
            bcdiv(config('referrals.income_percent'), "100", 2),
            2
        );
        $this->assertDatabaseHas('referral_incomes', [
            'amount' => $referralIncome,
            'user_id' => $referral->id,
            'referral_id' => $this->user->id,
        ]);
        self::assertEquals($referralIncome, $referral->fresh()->balance);
    }
}
