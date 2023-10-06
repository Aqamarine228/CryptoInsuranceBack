<?php

namespace Modules\ClientApi\Tests\Feature;

use Modules\ClientApi\Tests\ClientApiTestCase;

class WithdrawalRequestTest extends ClientApiTestCase
{

    public function testItCreatesSuccessfully(): void
    {
        $this->postJson('/api/v1/withdrawal-request')->assertOk();
    }
}
