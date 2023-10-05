<?php

namespace Modules\Admin\Tests\Feature;

use Modules\Admin\Models\InsuranceCoverageOption;
use Modules\Admin\Tests\AdminTestCase;
use Modules\ClientApi\Database\Factories\InsuranceCoverageOptionFactory;

class InsuranceCoverageOptionTest extends AdminTestCase
{
    public function testStore(): void
    {
        $data = [
            'coverage' => $this->faker->randomNumber(9, false),
            'price_percentage' => $this->faker->randomNumber(2, false),
        ];

        $response = $this->postJson(route('admin.insurance-coverage-option.store'), $data);
        $subscriptionOption = InsuranceCoverageOption::where($data)->first();
        self::assertNotNull($subscriptionOption);
        $response->assertRedirect(route('admin.insurance-coverage-option.edit', $subscriptionOption->id));
    }

    public function testUpdate(): void
    {
        $data = [
            'coverage' => $this->faker->randomNumber(9, false),
            'price_percentage' => $this->faker->randomNumber(2, false),
        ];

        $subscriptionOption = InsuranceCoverageOptionFactory::new()->create();
        $this
            ->putJson(route('admin.insurance-coverage-option.update', $subscriptionOption->id), $data)
            ->assertRedirect(route('admin.insurance-coverage-option.edit', $subscriptionOption->id));
        $this->assertDatabaseHas('insurance_coverage_options', [
            'id' => $subscriptionOption->id,
            ...$data
        ]);
    }

    public function testDestroy(): void
    {
        $subscriptionOption = InsuranceCoverageOptionFactory::new()->create();
        $this
            ->deleteJson(route('admin.insurance-coverage-option.destroy', $subscriptionOption->id))
            ->assertRedirect(route('admin.insurance-coverage-option.index'));
        $this->assertSoftDeleted($subscriptionOption);
    }
}
