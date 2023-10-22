<?php

namespace Modules\ClientApi\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ClientApi\Models\Insurance;

/**
 * class InsuranceFactory
 *
 * @mixin Insurance
 */
class InsuranceFactory extends Factory
{

    protected $model = Insurance::class;

    public function definition(): array
    {
        return [
            'expires_at' => now()->addWeek(),
            'paid' => false,
            'coverage' => $this->faker->randomNumber(9, false),
            'user_id' => UserFactory::new()->create()->id,
            'max_wallets_count' => config('insurance.default_wallets_count'),
        ];
    }
}
