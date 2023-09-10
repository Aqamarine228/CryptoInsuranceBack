<?php

namespace Modules\ClientApi\Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\ClientApi\Database\Factories\InsuranceSubscriptionOptionFactory;
use Modules\ClientApi\Http\Resources\InsuranceSubscriptionOptionResource;
use Modules\ClientApi\Tests\ClientApiTestCase;

class InsuranceSubscriptionOptionTest extends ClientApiTestCase
{

    public function testIndex(): void
    {
        $subscriptionOptions = InsuranceSubscriptionOptionFactory::new()->count(3)->create();
        $this->getJson('/api/v1/insurance-subscription-option')
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('success', true)
                ->where(
                    'response',
                    InsuranceSubscriptionOptionResource::collection($subscriptionOptions)
                        ->response()
                        ->getData(true)['data']
                )
            );
    }

}
