<?php

namespace Modules\ClientApi\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ClientApi\Models\InsuranceCoverageOption;

class InsuranceCoverageOptionFactory extends Factory
{
    protected $model = InsuranceCoverageOption::class;

    public function definition(): array
    {
        return [
            'coverage' => $this->faker->randomNumber(9, false),
            'price_percentage' => $this->faker->numberBetween(0, 100),
        ];
    }
}
