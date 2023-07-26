<?php

namespace Modules\ClientApi\Tests\Feature;

use Modules\ClientApi\Database\Factories\UserFactory;
use Modules\ClientApi\Tests\ClientApiTestCase;

class LoginTest extends ClientApiTestCase
{
    public function testSuccess()
    {
        $user = UserFactory::new()->create();

        $this->postJson('api/v1/login', [
            'email' => $user->email,
            'password' => UserFactory::STRONG_PASSWORD,
        ])->assertOk();

        $this->assertDatabaseCount('personal_access_tokens', 1);
    }

    public function testWrongCredentials()
    {
        $this->postJson('api/v1/login', [
            'email' => $this->faker->email,
            'password' => UserFactory::STRONG_PASSWORD,
        ])->assertBadRequest();

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }
}
