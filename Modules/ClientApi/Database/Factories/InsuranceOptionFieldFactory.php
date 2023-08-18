<?php

namespace Modules\ClientApi\Database\Factories;

use App\Enums\InsuranceOptionFieldType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\ClientApi\Models\InsuranceOptionField;

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
        $nameEn = $this->faker->name;
        return [
            'name_ru' => $this->faker->name,
            'name_en' => $nameEn,
            'type' => InsuranceOptionFieldType::TEXT->value,
            'insurance_option_id' => InsuranceOptionFactory::new()->create()->id,
            'required' => $this->faker->boolean,
            'slug' => Str::slug($nameEn),
        ];
    }
}
