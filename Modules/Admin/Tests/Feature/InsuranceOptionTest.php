<?php

namespace Modules\Admin\Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Admin\Database\Factories\InsuranceOptionFactory;
use Modules\Admin\Http\Resources\InsuranceOptionResource;
use Modules\Admin\Models\InsuranceOption;
use Modules\Admin\Tests\AdminTestCase;

class InsuranceOptionTest extends AdminTestCase
{
    const ITEMS_PER_SEARCH = 10;

    public function testStore(): void
    {
        $data = $this->generateTestData();
        $response = $this->postJson(route('admin.insurance-option.store'), $data);
        $insuranceOption = InsuranceOption::where($data)->first();
        self::assertNotNull($insuranceOption);
        $response->assertRedirect(route('admin.insurance-option.edit', $insuranceOption->id));
    }

    public function testUpdate(): void
    {
        $data = $this->generateTestData();
        $insuranceOption = InsuranceOptionFactory::new()->create();
        $this
            ->putJson(route('admin.insurance-option.update', $insuranceOption->id), $data)
            ->assertRedirect(route('admin.insurance-option.edit', $insuranceOption->id));
        $this->assertDatabaseHas('insurance_options', [
            'id' => $insuranceOption->id,
            ...$data
        ]);
    }

    private function generateTestData(): array
    {
        $data = [];
        foreach (locale()->supported() as $locale) {
            $data["name_$locale"] = $this->faker->name;
            $data["description_$locale"] = $this->faker->text(250);
        }
        return [
            'price' => 100,
            ...$data,
        ];
    }

    public function testDestroy(): void
    {
        $insuranceOption = InsuranceOptionFactory::new()->create();
        $this
            ->deleteJson(route('admin.insurance-option.destroy', $insuranceOption->id))
            ->assertRedirect(route('admin.insurance-option.index'));
        $this->assertSoftDeleted($insuranceOption);
    }

    public function testItSearchesCorrectly(): void
    {
        InsuranceOptionFactory::new()->count(10)->create();
        $this
            ->getJson(route('admin.insurance-option.search') . '?name=a')
            ->assertJson(fn(AssertableJson $json) => $json
                ->whereAll(InsuranceOptionResource::collection(InsuranceOption::search('a')
                    ->take(self::ITEMS_PER_SEARCH)
                    ->get()
                )->response()->getData(true)['data']))->assertOk();
    }
}
