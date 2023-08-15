<?php

namespace Modules\Admin\Database\Factories;

use App\Enums\InsuranceOptionFieldType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Models\InsuranceOptionField;

/**
 * Class InsuranceOptionFieldFactory
 *
 * @mixin InsuranceOptionField
 */
class InsuranceOptionFieldFactory extends Factory
{

    protected $model = InsuranceOptionField::class;

    public function definition(): array
    {
        return [
            'name_ru' => $this->faker->name,
            'name_en' => $this->faker->name,
            'type' => InsuranceOptionFieldType::TEXT->value,
            'insurance_option_id' => InsuranceOptionFactory::new()->create()->id
        ];
    }
}
