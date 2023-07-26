<?php

namespace Modules\ClientApi\Tests\Feature;

use Modules\ClientApi\Database\Factories\UserFactory;
use Modules\ClientApi\Tests\ClientApiTestCase;

class ReferralsTest extends ClientApiTestCase
{

    public function testAddSuccessful(): void
    {
        $referralId = $this->faker->uuid;
        UserFactory::new()->state([
            'referral_id' => $referralId
        ])->create();

        $this->postJson('/api/v1/register', [
            'first_name' => 'Referral',
            'last_name' => 'Referred',
            'email' => 'goodReferral@example.com',
            'password' => UserFactory::STRONG_PASSWORD,
            'password_confirmation' => UserFactory::STRONG_PASSWORD,
            'inviter_id' => $referralId,
        ]);

        $this->assertDatabaseHas('users', [
            'first_name' => 'Referral',
            'last_name' => 'Referred',
            'email' => 'goodReferral@example.com',
            'inviter_id' => $referralId,
        ]);
    }

    public function testAddReferralNotFound()
    {
        $this->postJson('/api/v1/register', [
            'first_name' => 'Referral',
            'last_name' => 'Referred',
            'email' => 'goodReferral@example.com',
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
}
