<?php

namespace Modules\ClientApi\Tests\Feature;

use App\Enums\PaymentTransactionStatus;
use Modules\ClientApi\Database\Factories\InsuranceInvoiceFactory;
use Modules\ClientApi\Database\Factories\InsuranceOptionFactory;
use Modules\ClientApi\Database\Factories\PaymentTransactionFactory;
use Modules\ClientApi\Models\Insurance;
use Modules\ClientApi\Models\InsuranceInvoice;
use Modules\ClientApi\Tests\ClientApiTestCase;

class PaymentTransactionTest extends ClientApiTestCase
{

    public function testItAcceptsShkeeperPaymentSuccessfully(): void
    {
        $insuranceInvoice = InsuranceInvoiceFactory::new()->state([
            'user_id' => $this->user->id,
        ])->create();

        $insuranceOptions = InsuranceOptionFactory::new()->count(10)->create();

        $paymentTransaction = PaymentTransactionFactory::new()->state([
            'user_id' => $this->user->id,
            'payable_type' => InsuranceInvoice::class,
            'payable_id' => $insuranceInvoice->id,
        ])->create();

        $insuranceInvoice->options()->sync($insuranceOptions->pluck('id'));

        $data = [
            "external_id" => $paymentTransaction->uuid,
            "crypto" => "BTC",
            "fiat" => "USD",
            "balance_fiat" => "100",
            "balance_crypto" => "0.0025",
            "fee_percent" => "2",
            "paid" => true,
            "transactions" => [
                [
                    "txid" => "ZZZZZZZZZZZZZZZZZZZ",
                    "date" => "2022-04-01 11:22:33",
                    "amount_crypto" => "0.0025",
                    "amount_fiat" => "100",
                    "trigger" => true,
                ],
            ],
        ];

        $this->postJson('/api/v1/shkeeper', $data, [
            'X-Shkeeper-API-Key' => config('services.shkeeper.api_key')
        ])->assertAccepted();

        $paymentTransaction = $paymentTransaction->fresh();
        self::assertSame(PaymentTransactionStatus::PAID->value, $paymentTransaction->status);

        $invoice = Insurance::where([
            'user_id' => $this->user->id,
        ])
            ->whereDate('expires_at', '>', now())
            ->whereDate(
                'expires_at',
                '<=',
                now()->addSeconds($insuranceInvoice->subscriptionOption->duration)
            )
            ->first();

        self::assertNotNull($invoice);
        foreach ($insuranceOptions as $insuranceOption) {
            self::assertTrue($invoice->options->contains($insuranceOption->id));
        }
    }

    public function testItHandlesUnpaidShkeeperPaymentCorrectly(): void
    {

        $insuranceInvoice = InsuranceInvoiceFactory::new()->state([
            'user_id' => $this->user->id,
        ])->create();

        $insuranceOptions = InsuranceOptionFactory::new()->count(10)->create();

        $paymentTransaction = PaymentTransactionFactory::new()->state([
            'user_id' => $this->user->id,
            'payable_type' => InsuranceInvoice::class,
            'payable_id' => $insuranceInvoice->id,
        ])->create();

        $insuranceInvoice->options()->sync($insuranceOptions->pluck('id'));

        $data = [
            "external_id" => $paymentTransaction->uuid,
            "crypto" => "BTC",
            "fiat" => "USD",
            "balance_fiat" => "100",
            "balance_crypto" => "0.0025",
            "fee_percent" => "2",
            "paid" => false,
            "transactions" => [
                [
                    "txid" => "ZZZZZZZZZZZZZZZZZZZ",
                    "date" => "2022-04-01 11:22:33",
                    "amount_crypto" => "0.0025",
                    "amount_fiat" => "100",
                    "trigger" => true,
                ],
            ],
        ];

        $this->postJson('/api/v1/shkeeper', $data, [
            'X-Shkeeper-API-Key' => config('services.shkeeper.api_key')
        ])->assertAccepted();
        $this->assertDatabaseEmpty('insurances');
    }

    public function testItChecksShkeeperToken(): void
    {
        $this->postJson('/api/v1/shkeeper', [], [
            'X-Shkeeper-API-Key' => 123
        ])->assertUnauthorized();
    }
}
