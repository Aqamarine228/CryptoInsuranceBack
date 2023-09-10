<?php

namespace Modules\ClientApi\Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\ClientApi\Database\Factories\InsurancePackFactory;
use Modules\ClientApi\Database\Factories\InsuranceSubscriptionOptionFactory;
use Modules\ClientApi\Http\Resources\InsurancePackResource;
use Modules\ClientApi\Models\InsurancePack;
use Modules\ClientApi\Tests\ClientApiTestCase;

class InsurancePackTest extends ClientApiTestCase
{

    public function testIndex(): void
    {
        $subscriptionOption = InsuranceSubscriptionOptionFactory::new()->create();
        $insurancePacks = InsurancePackFactory::new()->count(3)->create();
        $this->getJson('/api/v1/insurance-pack?insurance_subscription_option_id=' . $subscriptionOption->id)
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('success', true)
                ->where(
                    'response',
                    $insurancePacks->map(
                        fn(InsurancePack $insurancePack) => (new InsurancePackResource($insurancePack, $subscriptionOption))
                            ->response()
                            ->getData(true)['data']
                    )
                )
            );
    }

}
