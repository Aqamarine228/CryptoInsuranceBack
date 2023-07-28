<?php

namespace Modules\ClientApi\Tests;

use Modules\ClientApi\Database\Factories\UserFactory;
use Modules\ClientApi\Models\User;
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
