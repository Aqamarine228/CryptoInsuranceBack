<?php

namespace Modules\Admin\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Models\InsuranceSubscriptionOption;

/**
 * class InsuranceSubscriptionOptionFactory
 *
 * @mixin InsuranceSubscriptionOption
 */
class InsuranceSubscriptionOptionFactory extends Factory
{
    protected $model = InsuranceSubscriptionOption::class;

    public function definition(): array
    {
        return [
            'duration' => $this->faker->randomNumber(9, false),
            'sale_percentage' => $this->faker->numberBetween(0, 100),
        ];
    }
}
