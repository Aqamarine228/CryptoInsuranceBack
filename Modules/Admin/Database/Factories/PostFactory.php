<?php

namespace Modules\Admin\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\Models\Post;

/**
 * class PostFactory
 *
 * @mixin Post
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $localizedData = [];

        foreach (locale()->supported() as $locale) {
            $localizedData['title_' . $locale] = null;
            $localizedData['content_' . $locale] = null;
            $localizedData['short_title_' . $locale] = null;
            $localizedData['short_content_' . $locale] = null;
        }

        return array_merge([
            'picture' => null,
            'published_at' => null,
            'post_category_id' => null,
            'slug' => null,
        ], $localizedData);
    }
}
