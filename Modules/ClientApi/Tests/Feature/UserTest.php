<?php

namespace Modules\ClientApi\Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\ClientApi\Http\Resources\UserResource;
use Modules\ClientApi\Tests\ClientApiTestCase;

class UserTest extends ClientApiTestCase
{

    public function testShow(): void
    {
        $this->getJson('/api/v1/user')->assertStatus(200)->assertJson(fn(AssertableJson $json) => $json
            ->where('success', true)
            ->where('response', (new UserResource($this->user))->response()->getData(true)['data'])
        );
    }

}
