<?php

namespace Modules\Admin\Tests\Feature;

use App\Enums\InsuranceOptionFieldType;
use Modules\Admin\Database\Factories\InsuranceOptionFactory;
use Modules\Admin\Database\Factories\InsuranceOptionFieldFactory;
use Modules\Admin\Tests\AdminTestCase;

class InsuranceOptionFieldTest extends AdminTestCase
{

    public function testAdd(): void
    {
        $namesRu = [];
        $namesEn = [];
        $types = [];
        $required = [];

        $insuranceOption = InsuranceOptionFactory::new()->create();
        for ($i = 0; $i < 3; $i++) {
            $namesEn[] = $this->faker->name;
            $namesRu[] = $this->faker->name;
            $types[] = InsuranceOptionFieldType::TEXT->value;
            $required[] = $this->faker->boolean;
        }
        $this
            ->post(route('admin.insurance-option.field.add', $insuranceOption->id), [
                'names_en' => $namesEn,
                'names_ru' => $namesRu,
                'types' => $types,
                'required' => $required,
            ])
            ->assertRedirect();

        $testData = [];

        for ($i = 0; $i < 3; $i++) {
            $testData[] = [
                'name_ru' => $namesRu[$i],
                'name_en' => $namesEn[$i],
                'type' => $types[$i],
                'required' => $required[$i],
                'insurance_option_id' => $insuranceOption->id,
            ];
        }

        for ($i = 0; $i < 3; $i++) {
            self::assertDatabaseHas('insurance_option_fields', $testData[$i]);
        }
    }

    public function testUpdate(): void
    {
        $option = InsuranceOptionFieldFactory::new()->create();
        $data = [
            'name_ru' => $this->faker->name,
            'name_en' => $this->faker->name,
        ];
        $this->put(route('admin.insurance-option.field.update', $option->id), $data)->assertRedirect();

        $this->assertDatabaseHas('insurance_option_fields', [
            'id' => $option->id,
            'insurance_option_id' => $option->insurance_option_id,
            ...$data,
        ]);
    }

    public function testDelete(): void
    {
        $option = InsuranceOptionFieldFactory::new()->create();
        $this->delete(route('admin.insurance-option.field.destroy', $option->id))->assertRedirect();

        $this->assertSoftDeleted('insurance_option_fields', [
            'id' => $option->id,
        ]);
    }
}
