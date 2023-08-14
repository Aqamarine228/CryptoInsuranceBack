<?php

namespace Modules\Admin\Tests\Feature;

use Modules\Admin\Database\Factories\InsuranceOptionFactory;
use Modules\Admin\Models\InsuranceOption;
use Modules\Admin\Tests\AdminTestCase;

class InsuranceOptionTest extends AdminTestCase
{

    public function testStore(): void
    {
        $data = [
            'name_ru' => $this->faker->name,
            'name_en' => $this->faker->name,
            'description_en' => $this->faker->text(250),
            'description_ru' => $this->faker->text(250),
            'price' => 100
        ];
        $response = $this->postJson(route('admin.insurance-option.store'), $data);
        $insuranceOption = InsuranceOption::where($data)->first();
        self::assertNotNull($insuranceOption);
        $response->assertRedirect(route('admin.insurance-option.edit', $insuranceOption->id));
    }

    public function testUpdate(): void
    {
        $insuranceOption = InsuranceOptionFactory::new()->create();
        $data = [
            'name_ru' => $this->faker->name,
            'name_en' => $this->faker->name,
            'description_en' => $this->faker->text(250),
            'description_ru' => $this->faker->text(250),
            'price' => 100
        ];

        $this
            ->putJson(route('admin.insurance-option.update', $insuranceOption->id), $data)
            ->assertRedirect(route('admin.insurance-option.edit', $insuranceOption->id));
        $this->assertDatabaseHas('insurance_options', [
            'id' => $insuranceOption->id,
            ...$data
        ]);
    }

    public function testDestroy(): void
    {
        $insuranceOption = InsuranceOptionFactory::new()->create();
        $this
            ->deleteJson(route('admin.insurance-option.destroy', $insuranceOption->id))
            ->assertRedirect(route('admin.insurance-option.index'));
        $this->assertSoftDeleted($insuranceOption);
    }
}
