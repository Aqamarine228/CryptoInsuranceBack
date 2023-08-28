<?php

namespace Modules\Admin\Tests\Feature;

use Modules\Admin\Database\Factories\InsuranceSubscriptionOptionFactory;
use Modules\Admin\Models\InsuranceSubscriptionOption;
use Modules\Admin\Tests\AdminTestCase;

class InsuranceSubscriptionOptionTest extends AdminTestCase
{

    const SECONDS_PER_DAY = 60 * 60 * 24;

    public function testStore(): void
    {
        $data = [
            'sale_percentage' => $this->faker->randomNumber(2, false),
            'days' => $this->faker->randomNumber(5, false),
        ];

        $response = $this->postJson(route('admin.insurance-subscription-option.store'), $data);
        $subscriptionOption = InsuranceSubscriptionOption::where([
            'sale_percentage' => $data['sale_percentage'],
            'duration' => $data['days'] * self::SECONDS_PER_DAY,
        ])->first();
        self::assertNotNull($subscriptionOption);
        $response->assertRedirect(route('admin.insurance-subscription-option.edit', $subscriptionOption->id));
    }

    public function testUpdate(): void
    {
        $data = [
            'sale_percentage' => $this->faker->randomNumber(2, false),
            'days' => $this->faker->randomNumber(5, false),
        ];

        $subscriptionOption = InsuranceSubscriptionOptionFactory::new()->create();
        $this
            ->putJson(route('admin.insurance-subscription-option.update', $subscriptionOption->id), $data)
            ->assertRedirect(route('admin.insurance-subscription-option.edit', $subscriptionOption->id));
        $this->assertDatabaseHas('insurance_subscription_options', [
            'id' => $subscriptionOption->id,
            'sale_percentage' => $data['sale_percentage'],
            'duration' => $data['days'] * self::SECONDS_PER_DAY,
        ]);
    }

    public function testDestroy(): void
    {
        $subscriptionOption = InsuranceSubscriptionOptionFactory::new()->create();
        $this
            ->deleteJson(route('admin.insurance-subscription-option.destroy', $subscriptionOption->id))
            ->assertRedirect(route('admin.insurance-subscription-option.index'));
        $this->assertSoftDeleted($subscriptionOption);
    }
}
