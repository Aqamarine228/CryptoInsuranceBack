<?php

namespace Modules\ClientApi\Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\ClientApi\Database\Factories\InsuranceFactory;
use Modules\ClientApi\Http\Resources\InsuranceResource;
use Modules\ClientApi\Tests\ClientApiTestCase;

class InsuranceTest extends ClientApiTestCase
{

    public function testItIndexesSuccessfully(): void
    {
        $insurances = InsuranceFactory::new()->count(10)->state([
            'expires_at' => now()->addMonth(),
            'user_id' => $this->user->id,
            'paid' => true,
        ])->create();

        $insurances->load('options');

        $this->getJson('/api/v1/insurance')->assertJson(
            fn (AssertableJson $json) => $json
                ->where('success', true)
                ->where('response', InsuranceResource::collection($insurances)->response()->getData(true)['data'])
        );
    }

    public function testItShowsSuccessfully(): void
    {
        $insurance = InsuranceFactory::new()->state([
            'expires_at' => now()->addMonth(),
            'user_id' => $this->user->id,
            'paid' => true,
        ])->create();

        $insurance->load('options');

        $this->getJson('/api/v1/insurance/' . $insurance->id)->assertJson(
            fn (AssertableJson $json) => $json
            ->where('success', true)
            ->where('response', (new InsuranceResource($insurance))->response()->getData(true)['data'])
        );
    }
}
