<?php

namespace Modules\ClientApi\Tests\Feature;

use App\Enums\Currency;
use App\Enums\InsuranceInvoiceStatus;
use Illuminate\Testing\Fluent\AssertableJson;
use Modules\ClientApi\Database\Factories\InsuranceOptionFactory;
use Modules\ClientApi\Database\Factories\InsurancePackFactory;
use Modules\ClientApi\Database\Factories\InsuranceSubscriptionOptionFactory;
use Modules\ClientApi\Http\Resources\InsuranceInvoiceResource;
use Modules\ClientApi\Models\InsuranceInvoice;
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
                ->where(
                    'response',
                    (new InsuranceInvoiceResource(InsuranceInvoice::first()))
                        ->response()
                        ->getData(true)['data']
                )
        );

        $this->assertDatabaseHas('insurance_invoices', [
            'user_id' => $this->user->id,
            'currency' => Currency::USD->value,
            'id' => 1,
        ]);
    }

    public function testItValidatesCustomCreationCorrectly(): void
    {
        $this->postJson('/api/v1/insurance-invoice/custom', [
            'insurance_options' => [1, 2, 3],
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
                ->where(
                    'response',
                    (new InsuranceInvoiceResource(InsuranceInvoice::first()))
                        ->response()
                        ->getData(true)['data']
                )
        );

        $this->assertDatabaseHas('insurance_invoices', [
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
}
