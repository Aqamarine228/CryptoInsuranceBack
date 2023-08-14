<?php

namespace Modules\Admin\Tests\Feature;

use Modules\Admin\Database\Factories\InsuranceOptionFactory;
use Modules\Admin\Database\Factories\InsurancePackFactory;
use Modules\Admin\Models\InsurancePack;
use Modules\Admin\Tests\AdminTestCase;

class InsurancePackTest extends AdminTestCase
{

    public function testStore(): void
    {
        $insuranceOptions = InsuranceOptionFactory::new()->count(10)->create();
        $data = [
            'name_ru' => $this->faker->name,
            'name_en' => $this->faker->name,
            'description_en' => $this->faker->text(250),
            'description_ru' => $this->faker->text(250),
            'price' => 100,
            'insurance_options' => $insuranceOptions->pluck('id')->toArray(),
        ];
        $response = $this->postJson(route('admin.insurance-pack.store'), $data);
        unset($data['insurance_options']);
        $insurancePack = InsurancePack::where($data)->first();
        self::assertNotNull($insurancePack);
        self::assertTrue(
            $insurancePack
                ->insuranceOptions()
                ->whereIn('insurance_options.id', $insuranceOptions->pluck('id'))
                ->exists()
        );
        $response->assertRedirect(route('admin.insurance-pack.edit', $insurancePack->id));
    }

    public function testUpdate(): void
    {
        $insurancePack = InsurancePackFactory::new()->create();
        $previousInsuranceOptions = InsuranceOptionFactory::new()->count(10)->create();
        $newInsuranceOptions = InsuranceOptionFactory::new()->count(10)->create();
        $insurancePack->insuranceOptions()->sync($previousInsuranceOptions->pluck('id')->toArray());
        $data = [
            'name_ru' => $this->faker->name,
            'name_en' => $this->faker->name,
            'description_en' => $this->faker->text(250),
            'description_ru' => $this->faker->text(250),
            'price' => 100,
            'insurance_options' => $newInsuranceOptions->pluck('id')->toArray(),
        ];

        $this
            ->putJson(route('admin.insurance-pack.update', $insurancePack->id), $data)
            ->assertRedirect(route('admin.insurance-pack.edit', $insurancePack->id));
        self::assertFalse(
            $insurancePack
                ->insuranceOptions()
                ->whereIn('insurance_options.id', $previousInsuranceOptions->pluck('id'))
                ->exists()
        );
        self::assertTrue(
            $insurancePack
                ->insuranceOptions()
                ->whereIn('insurance_options.id', $newInsuranceOptions->pluck('id'))
                ->exists()
        );
        unset($data['insurance_options']);
        $this->assertDatabaseHas('insurance_packs', [
            'id' => $insurancePack->id,
            ...$data
        ]);
    }

    public function testDestroy(): void
    {
        $insurancePack = InsurancePackFactory::new()->create();
        $this
            ->deleteJson(route('admin.insurance-pack.destroy', $insurancePack->id))
            ->assertRedirect(route('admin.insurance-pack.index'));
        $this->assertSoftDeleted($insurancePack);
    }
}
