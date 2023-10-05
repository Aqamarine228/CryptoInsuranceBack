<?php

namespace Modules\ClientApi\Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\ClientApi\Database\Factories\InsuranceCoverageOptionFactory;
use Modules\ClientApi\Http\Resources\InsuranceCoverageOptionResource;
use Modules\ClientApi\Tests\ClientApiTestCase;

class InsuranceCoverageOptionTest extends ClientApiTestCase
{

    public function testItIndexesSuccessfully(): void
    {
        $options = InsuranceCoverageOptionFactory::new()->count(10)->create();
        $this->getJson('/api/v1/insurance-coverage-option')->assertJson(
            fn (AssertableJson $json) => $json
            ->where('success', true)
            ->where('response', InsuranceCoverageOptionResource::collection($options)
                ->response()
                ->getData(true)['data'])
        );
    }
}
