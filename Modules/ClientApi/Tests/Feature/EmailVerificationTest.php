<?php

namespace Modules\ClientApi\Tests\Feature;

use Modules\ClientApi\Tests\ClientApiTestCase;

class EmailVerificationTest extends ClientApiTestCase
{

    public function testResendEmailVerification(): void
    {
        $this->postJson('/api/v1/email/resend-verification')->assertOk();
    }
}
