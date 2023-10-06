<?php

namespace Modules\ClientApi\Tests\Feature;

use App\Enums\TimePeriod;
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
            'created_at' => now(),
        ])->count(3)->create();

        ReferralIncomeFactory::new()->state([
            'user_id' => $this->user->id,
            'created_at' => now()->subYear(),
        ])->count(3)->create();

        $this->json('GET', '/api/v1/referral-income', [
            'time_period' => TimePeriod::MONTH->value,
        ])->assertOk()->assertJson(
            fn (AssertableJson $json) => $json
            ->where('success', true)
            ->where(
                'response.data',
                ReferralIncomeResource::collection($referralIncome->take(3))
                ->response()
                ->getData(true)['data']
            )
        );
    }
}
