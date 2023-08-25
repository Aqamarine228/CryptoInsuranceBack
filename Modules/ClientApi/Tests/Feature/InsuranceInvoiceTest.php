<?php

namespace Modules\ClientApi\Tests\Feature;

use App\Enums\Currency;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\ClientApi\Database\Factories\InsuranceOptionFactory;
use Modules\ClientApi\Database\Factories\InsurancePackFactory;
use Modules\ClientApi\Database\Factories\InsuranceSubscriptionOptionFactory;
use Modules\ClientApi\Tests\ClientApiTestCase;

class InsuranceInvoiceTest extends ClientApiTestCase
{

    public function testItCreatesInvoiceFromOptions(): void
    {
        $insuranceOptions = InsuranceOptionFactory::new()->count(10)->create();
        $subscriptionOption = InsuranceSubscriptionOptionFactory::new()->create();

        $this->postJson('/api/v1/insurance-invoice/custom', [
            'insurance_options' => $insuranceOptions->pluck('id')->toArray(),
            'insurance_subscription_option_id' => $subscriptionOption->id,
        ])->assertOk()->assertJson(
            fn (AssertableJson $json) => $json
                ->where('success', true)
                ->where('response', [
                    'amount' => $this->calculatePrice(
                        $insuranceOptions->sum('price'),
                        $subscriptionOption->sale_percentage
                    ),
                    'currency' => Currency::USD->value,
                    'id' => 1,
                ])
        );

        $this->assertDatabaseHas('insurance_invoices', [
            'amount' => $this->calculatePrice(
                $insuranceOptions->sum('price'),
                $subscriptionOption->sale_percentage
            ),
            'user_id' => $this->user->id,
            'currency' => Currency::USD->value,
            'id' => 1,
        ]);
    }

    public function testItValidatesCustomCreationCorrectly(): void
    {
        $this->postJson('/api/v1/insurance-invoice/custom', [
            'insurance_options' => [1,2,3],
            'insurance_subscription_option_id' => 1,
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'insurance_options.0',
                'insurance_options.1',
                'insurance_options.2',
                'insurance_subscription_option_id',
            ]);
    }

    public function testItCreatesInvoiceFromPack(): void
    {
        $insurancePack = InsurancePackFactory::new()->create();
        $subscriptionOption = InsuranceSubscriptionOptionFactory::new()->create();

        $this->postJson('/api/v1/insurance-invoice/from-pack', [
            'insurance_pack_id' => $insurancePack->id,
            'insurance_subscription_option_id' => $subscriptionOption->id,
        ])->assertOk()->assertJson(
            fn (AssertableJson $json) => $json
                ->where('success', true)
                ->where('response', [
                    'amount' => $this->calculatePrice(
                        $insurancePack->price,
                        $subscriptionOption->sale_percentage
                    ),
                    'currency' => Currency::USD->value,
                    'id' => 1,
                ])
        );

        $this->assertDatabaseHas('insurance_invoices', [
            'amount' => $this->calculatePrice(
                $insurancePack->price,
                $subscriptionOption->sale_percentage
            ),
            'user_id' => $this->user->id,
            'currency' => Currency::USD->value,
            'id' => 1,
        ]);
    }

    public function testItValidatesFromPackCreationCorrectly(): void
    {
        $this->postJson('/api/v1/insurance-invoice/from-pack', [
            'insurance_pack_id' => 1,
            'insurance_subscription_option_id' => 1,
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'insurance_subscription_option_id',
                'insurance_pack_id',
            ]);
    }

    private function calculatePrice(float $price, float $salePercentage): float
    {
        return (float)bcmul($price, bcdiv($salePercentage, "100", 2), 2);
    }

    //    Test for crypto transaction creations, needs to be used with enabled api
    //    public function testItCreatesCryptoTransaction(): void
    //    {
    //        $invoice = InsuranceInvoiceFactory::new()->create();
    //        $this->postJson("/api/v1/insurance-invoice/$invoice->id/transaction", [
    //            'cryptocurrency' => Cryptocurrency::BTC->value,
    //        ])->dd();
    //    }
}
