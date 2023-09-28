<?php

namespace Modules\ClientApi\Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\ClientApi\Database\Factories\UserFactory;
use Modules\ClientApi\Http\Resources\ReferralResource;
use Modules\ClientApi\Models\User;
use Modules\ClientApi\Tests\ClientApiTestCase;

class ReferralsTest extends ClientApiTestCase
{

    public function testAddSuccessful(): void
    {
        $referralId = $this->faker->uuid;
        $referral = UserFactory::new()->state([
            'referral_id' => $referralId
        ])->create();

        $this->postJson('/api/v1/register', [
            'first_name' => 'Referral',
            'last_name' => 'Referred',
            'email' => 'goodreferral@example.com',
            'password' => UserFactory::STRONG_PASSWORD,
            'password_confirmation' => UserFactory::STRONG_PASSWORD,
            'inviter_id' => $referralId,
        ]);

        $this->assertDatabaseHas('users', [
            'first_name' => 'Referral',
            'last_name' => 'Referred',
            'email' => 'goodReferral@example.com',
            'inviter_id' => $referral->id,
        ]);
    }

    public function testAddReferralNotFound()
    {
        $this->postJson('/api/v1/register', [
            'first_name' => 'Referral',
            'last_name' => 'Referred',
            'email' => 'goodreferral@example.com',
            'password' => UserFactory::STRONG_PASSWORD,
            'password_confirmation' => UserFactory::STRONG_PASSWORD,
            'inviter_id' => $this->faker->uuid,
        ])->assertUnprocessable()->assertInvalid(['inviter_id']);

        $this->assertDatabaseMissing('users', [
            'first_name' => 'Referral',
            'last_name' => 'Referred',
            'email' => 'goodReferral@example.com',
        ]);
    }

    public function testIndex(): void
    {
        $referrals = UserFactory::new()->state([
            'inviter_id' => $this->user->id,
        ])->count(10)->create();
        $this->getJson('/api/v1/referrals')->assertOk()->assertJson(
            fn (AssertableJson $json) => $json
            ->where('success', true)
            ->where(
                'response.data',
                ReferralResource::collection($referrals->limit(5))->response()->getData(true)['data']
            )
        );
    }
}
