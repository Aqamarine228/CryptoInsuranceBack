<?php

namespace Modules\ClientApi\Tests\Feature;

use Modules\ClientApi\Tests\ClientApiTestCase;

class WithdrawalRequestTest extends ClientApiTestCase
{
//    public function testItCreatesSuccessfully(): void
//    {
//        $this->user->update([
//            'balance' => 1337,
//        ]);
//        $this->postJson('/api/v1/withdrawal-request', [
//            'amount' => 337,
//        ])->assertOk();
//        self::assertEquals(1000, $this->user->fresh()->balance);
//    }

    public function testItValidatesSuccessfully(): void
    {
        $this->postJson('/api/v1/withdrawal-request', [
            'amount' => 337,
        ])->assertUnprocessable()->assertJsonValidationErrors(['amount']);
    }
}
