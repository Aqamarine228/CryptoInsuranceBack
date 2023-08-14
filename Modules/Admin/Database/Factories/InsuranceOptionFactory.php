<?php

namespace Modules\Admin\Database\Factories;

use App\Enums\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Admin\Models\InsuranceOption;

class InsuranceOptionFactory extends Factory
{

    protected $model = InsuranceOption::class;

    public function definition(): array
    {
        $nameEn = $this->faker->name;
        return [
            'name_en' => $nameEn,
            'name_ru' => $this->faker->name,
            'description_en' => $this->faker->text(250),
            'description_ru' => $this->faker->text(250),
            'price' => $this->faker->randomNumber(1, 100),
            'slug' => Str::slug($nameEn),
            'currency' => Currency::USDT->value
        ];
    }
}
