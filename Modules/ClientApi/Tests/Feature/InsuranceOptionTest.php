<?php

namespace Modules\ClientApi\Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\ClientApi\Database\Factories\InsuranceOptionFactory;
use Modules\ClientApi\Tests\ClientApiTestCase;

class InsuranceOptionTest extends ClientApiTestCase
{

    public function testItPaginatesSuccessfully(): void
    {
        $options = InsuranceOptionFactory::new()->count(20)->create();
        $dataToAssert = [];
        foreach ($options->take(15) as $option) {
            $dataToAssert[] = [
                "id" => $option->id,
                "name" => $option->name_en,
                "description" => $option->description_en,
                "price" => $option->price,
                "currency" => $option->currency,
            ];
        }

        $this->getJson('/api/v1/insurance-option')->assertOk()->assertJson(
            fn (AssertableJson $json) => $json
                ->where('success', true)
                ->where('response.data', $dataToAssert)
        );
    }

    public function testItSearchesSuccessfully(): void
    {
        InsuranceOptionFactory::new()->count(10)->create();
        $name = $this->faker->name;
        $toSearch = InsuranceOptionFactory::new()->state([
            'name_en' => $name,
        ])->create();

        $this->getJson("/api/v1/insurance-option?search=$name")->assertOk()->assertJson(
            fn (AssertableJson $json) => $json
                ->where('success', true)
                ->where('response.data.0', [
                    "id" => $toSearch->id,
                    "name" => $toSearch->name_en,
                    "description" => $toSearch->description_en,
                    "price" => $toSearch->price,
                    "currency" => $toSearch->currency,
                ])
        );
    }
}
