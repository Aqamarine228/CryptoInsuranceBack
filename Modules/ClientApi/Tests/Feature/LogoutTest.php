<?php

namespace Modules\ClientApi\Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Modules\ClientApi\Database\Factories\UserFactory;
use Modules\ClientApi\Tests\ClientApiTestCase;

class LogoutTest extends ClientApiTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Auth::logout();
    }

    public function testLogoutUser()
    {
        $user = UserFactory::new()->create();

        $response = $this->postJson('api/v1/login', [
            'email' => $user->email,
            'password' => UserFactory::STRONG_PASSWORD,
        ])->assertOk();


        $this->assertDatabaseCount('personal_access_tokens', 1);

        $token = $response->json()['response'];
        $headers = ['Authorization' => 'Bearer ' . $token];

        $this->postJson('api/v1/logout', [], $headers)->assertOk();

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }
}
