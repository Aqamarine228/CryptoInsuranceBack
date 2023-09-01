<?php

namespace Modules\Admin\Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Modules\Admin\Database\Factories\PostTagFactory;
use Modules\Admin\Http\Resources\PostTagResource;
use Modules\Admin\Models\PostTag;
use Modules\Admin\Tests\AdminTestCase;

class PostTagTest extends AdminTestCase
{
    const ITEMS_PER_SEARCH = 10;

    public function testItStoresSuccessfully(): void
    {
        $data = $this->generateData();
        $this->postJson(route('admin.post-tag.store'), $data)->assertRedirect();
        $this->assertDatabaseHas('post_tags', $data);
    }

    public function testItDestroysSuccessfully(): void
    {
        $postCategory = PostTagFactory::new()->create();
        $this
            ->deleteJson(route('admin.post-tag.destroy', $postCategory->id))
            ->assertRedirect(route('admin.post-tag.index'));
        $this->assertDatabaseMissing('post_tags', ['id' => $postCategory->id]);

    }

    public function testItSearchesCorrectly(): void
    {
        PostTagFactory::new()->count(10)->create();
        $this
            ->getJson(route('admin.post-tag.search') . '?name=a')
            ->assertJson(fn(AssertableJson $json) => $json
                ->whereAll(PostTagResource::collection(PostTag::search('a')
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
