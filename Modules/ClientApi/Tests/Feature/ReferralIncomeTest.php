<?php

namespace Modules\ClientApi\Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\ClientApi\Database\Factories\ReferralIncomeFactory;
use Modules\ClientApi\Http\Resources\ReferralIncomeResource;
use Modules\ClientApi\Tests\ClientApiTestCase;

class ReferralIncomeTest extends ClientApiTestCase
{
    public function testIndex(): void
    {
        $referralIncome = ReferralIncomeFactory::new()->state([
            'user_id' => $this->user->id,
        ])->count(10)->create();

        $this->getJson('/api/v1/referral-income')->assertOk()->assertJson(fn(AssertableJson $json) => $json
            ->where('success', true)
            ->where('response.data', ReferralIncomeResource::collection($referralIncome)->response()->getData(true)['data'])
        );

    }
}
