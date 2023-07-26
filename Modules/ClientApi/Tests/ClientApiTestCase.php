<?php

namespace Modules\ClientApi\Tests;

use Illuminate\Foundation\Auth\User;
use Modules\ClientApi\Database\Factories\UserFactory;
use Tests\TestCase;

class ClientApiTestCase extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndSetDefaultUser();
    }

    private function createAndSetDefaultUser(): void
    {
        $this->user = UserFactory::new()->create();
        $this->actingAs($this->user);
    }
}
