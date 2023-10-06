<?php

namespace Modules\Admin\Database\Factories;

use App\Enums\InsuranceRequestStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Models\InsuranceRequest;

class InsuranceRequestFactory extends Factory
{
    protected $model = InsuranceRequest::class;

    public function definition(): array
    {
        return [
            'user_id' => UserFactory::new()->create()->id,
            'insurance_option_id' => InsuranceOptionFactory::new()->create()->id,
            'status' => InsuranceRequestStatus::PENDING->value,
            'coverage' => $this->faker->randomNumber([0,9], false),
        ];
    }
}
