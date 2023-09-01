<?php

namespace Modules\Admin\Database\Factories;

use App\Actions\GenerateSlug;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Models\PostCategory;

/**
 * class PostCategoryFactory
 *
 * @mixin PostCategory
 */
class PostCategoryFactory extends Factory
{
    protected $model = PostCategory::class;

    public function definition(): array
    {
        $data = [];

        foreach (locale()->supported() as $locale) {
            $data['name_' . $locale] = $this->faker->name;
        }

        $data['slug'] = GenerateSlug::execute($data['name_' . locale()->default()]);

        return $data;
    }
}
