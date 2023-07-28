<?php

namespace Modules\Admin\Database\Factories;

use App\Enums\ReferralRequestStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Models\ReferralRequest;

class ReferralRequestFactory extends Factory
{

    protected $model = ReferralRequest::class;

    public function definition(): array
    {
        return [
            'status' => ReferralRequestStatus::PENDING,
            'telegram_account' => $this->faker->firstName,
            'approved_at' => null,
            'user_id' => UserFactory::new()->create()->id,
            'document_photo' => 'file.jpg',
            'address' => $this->faker->address,
        ];
    }
}
