<?php

namespace Modules\ClientApi\Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\ClientApi\Database\Factories\InsuranceOptionFactory;
use Modules\ClientApi\Database\Factories\InsuranceSubscriptionOptionFactory;
use Modules\ClientApi\Tests\ClientApiTestCase;

class InsuranceTest extends ClientApiTestCase
{

    public function testItGetsPriceSuccessfully(): void
    {
        $options = InsuranceOptionFactory::new()->count(10)->create();
        $subscriptionOptions = InsuranceSubscriptionOptionFactory::new()->count(10)->create();
        $result = [];
        foreach ($subscriptionOptions as $subscriptionOption) {
            $result[] = [
                'subscription_option_id' => $subscriptionOption->id,
                'duration' => $subscriptionOption->duration,
            ];
        }
        $this->postJson('/api/v1/insurance/price', [
            'insurance_options' => $options->pluck('id')->toArray(),
        ])->assertOk()->assertJson(
            fn (AssertableJson $json) => $json
                ->where('success', true)
                ->where('response', $result)
        );
    }
}
