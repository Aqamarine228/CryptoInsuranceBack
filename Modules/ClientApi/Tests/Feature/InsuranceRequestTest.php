<?php

namespace Modules\ClientApi\Tests\Feature;

use App\Enums\InsuranceOptionFieldType;
use App\Enums\InsuranceRequestStatus;
use Modules\ClientApi\Database\Factories\InsuranceFactory;
use Modules\ClientApi\Database\Factories\InsuranceOptionFactory;
use Modules\ClientApi\Database\Factories\InsuranceOptionFieldFactory;
use Modules\ClientApi\Models\InsuranceRequest;
use Modules\ClientApi\Tests\ClientApiTestCase;

class InsuranceRequestTest extends ClientApiTestCase
{

    public function testItCreatesSuccessfully(): void
    {
        $insurance = InsuranceFactory::new()->state([
            'user_id' => $this->user->id,
        ])->create();
        $insuranceOption = InsuranceOptionFactory::new()->create();
        $insurance->options()->sync($insurance->id);
        $fields = [
            InsuranceOptionFieldFactory::new()->state([
                'type' => InsuranceOptionFieldType::TEXT,
                'required' => true,
                'insurance_option_id' => $insuranceOption->id,
            ])->create(),
            InsuranceOptionFieldFactory::new()->state([
                'type' => InsuranceOptionFieldType::NUMBER,
                'required' => true,
                'insurance_option_id' => $insuranceOption->id,
            ])->create(),
            InsuranceOptionFieldFactory::new()->state([
                'type' => InsuranceOptionFieldType::TEXT,
                'required' => false,
                'insurance_option_id' => $insuranceOption->id,
            ])->create(),
            InsuranceOptionFieldFactory::new()->state([
                'type' => InsuranceOptionFieldType::NUMBER,
                'required' => false,
                'insurance_option_id' => $insuranceOption->id,
            ])->create(),
            InsuranceOptionFieldFactory::new()->state([
                'type' => InsuranceOptionFieldType::TEXT,
                'required' => false,
                'insurance_option_id' => $insuranceOption->id,
            ])->create(),
        ];

        $fields[0]->value = $this->faker->name;
        $fields[1]->value = $this->faker->numberBetween();
        $fields[4]->value = $this->faker->name;

        $this->postJson("/api/v1/insurance-request/$insuranceOption->id", [
            $fields[0]->slug => $fields[0]->value,
            $fields[1]->slug => $fields[1]->value,
            $fields[4]->slug => $fields[4]->value,
        ])->assertOk();

        $insuranceRequest = InsuranceRequest::where([
            'insurance_option_id' => $insuranceOption->id,
            'user_id' => $this->user->id,
            'status' => InsuranceRequestStatus::PENDING,
        ])->first();

        self::assertNotNull($insuranceRequest);

        foreach ($fields as $field) {
            self::assertDatabaseHas('insurance_request_fields', [
                'insurance_request_id' => $insuranceRequest->id,
                'value' => $field->value,
                'insurance_option_field_id' => $field->id,
            ]);
        }
    }
}
