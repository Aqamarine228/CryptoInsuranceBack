<?php

namespace Modules\ClientApi\Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\ClientApi\Database\Factories\InsuranceOptionFactory;
use Modules\ClientApi\Database\Factories\InsuranceSubscriptionOptionFactory;
use Modules\ClientApi\Models\Insurance;
use Modules\ClientApi\Models\InsuranceInvoice;
use Modules\ClientApi\Tests\ClientApiTestCase;

class InsuranceOptionTest extends ClientApiTestCase
{

    public function testItIndexesSuccessfully(): void
    {
        $options = InsuranceOptionFactory::new()->count(20)->create();
        $subscriptionOption = InsuranceSubscriptionOptionFactory::new()->create();
        $dataToAssert = [];
        foreach ($options as $option) {
            $dataToAssert[] = [
                "id" => $option->id,
                "name" => $option->name_en,
                "description" => $option->description_en,
                "price" => (float)$subscriptionOption->calculatePrice($option->price),
                "currency" => $option->currency,
            ];
        }

        $this->json('GET', '/api/v1/insurance-option', [
            'insurance_subscription_option_id' => $subscriptionOption->id,
        ])->assertOk()->assertJson(
            fn (AssertableJson $json) => $json
                ->where('success', true)
                ->where('response', $dataToAssert)
        );
    }
}
