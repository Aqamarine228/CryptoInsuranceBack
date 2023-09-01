<?php

namespace Modules\Admin\Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Admin\Database\Factories\PostCategoryFactory;
use Modules\Admin\Database\Factories\PostFactory;
use Modules\Admin\Http\Resources\PostCategoryResource;
use Modules\Admin\Models\PostCategory;
use Modules\Admin\Tests\AdminTestCase;

class PostCategoryTest extends AdminTestCase
{
    const ITEMS_PER_SEARCH = 10;

    public function testItStoresSuccessfully(): void
    {
        $data = $this->generateData();
        $this->postJson(route('admin.post-category.store'), $data)->assertRedirect();
        $this->assertDatabaseHas('post_categories', $data);
    }

    public function testItUpdatesSuccessfully(): void
    {
        $postCategory = PostCategoryFactory::new()->create();
        $data = $this->generateData();
        $this->putJson(route('admin.post-category.update', $postCategory->id), $data)->assertRedirect();
        $data['id'] = $postCategory->id;
        $this->assertDatabaseHas('post_categories', $data);
    }

    public function testItDestroysSuccessfully(): void
    {
        $postCategory = PostCategoryFactory::new()->create();
        $this
            ->deleteJson(route('admin.post-category.destroy', $postCategory->id))
            ->assertRedirect(route('admin.post-category.index'));
        $this->assertDatabaseMissing('post_categories', ['id' => $postCategory->id]);

    }

    public function testCantDestroyWhenHasPosts(): void
    {
        $postCategory = PostCategoryFactory::new()->create();
        PostFactory::new()->state([
            'post_category_id' => $postCategory->id,
        ])->create();
        $this
            ->deleteJson(route('admin.post-category.destroy', $postCategory->id))
            ->assertRedirect();
        $this->assertDatabaseHas('post_categories', ['id' => $postCategory->id]);
    }

    public function testItSearchesCorrectly(): void
    {
        PostCategoryFactory::new()->count(10)->create();
        $this
            ->getJson(route('admin.post-category.search') . '?name=a')
            ->assertJson(fn(AssertableJson $json) => $json
                ->whereAll(PostCategoryResource::collection(PostCategory::search('a')
                    ->take(self::ITEMS_PER_SEARCH)
                    ->get()
                )->response()->getData(true)['data']))->assertOk();
    }

    private function generateData(): array
    {
        $data = [];

        foreach (locale()->supported() as $locale) {
            $data['name_' . $locale] = $this->faker->name;
        }
        return $data;
    }
}
