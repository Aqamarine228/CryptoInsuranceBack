<?php

namespace Modules\Admin\Tests\Feature;

use App\Actions\GenerateFileName;
use Illuminate\Http\UploadedFile;
use Modules\Admin\Database\Factories\PostTagFactory;
use Modules\Admin\Database\Factories\PostCategoryFactory;
use Modules\Admin\Database\Factories\PostFactory;
use Modules\Admin\Tests\AdminTestCase;
use Storage;

class PostTest extends AdminTestCase
{

    public function testItCreatesSuccessfully(): void
    {
        $this->postJson(route('admin.post.store'))->assertRedirect();

        $data = [
            'picture' => null,
            'published_at' => null,
            'post_category_id' => null,
            'slug' => null,
        ];

        $this->assertDatabaseHas('posts', array_merge($data, $this->makeLocaleData()));
    }

    public function testItGetsEmptyPostSuccessfully(): void
    {
        $post = PostFactory::new()->create();
        $this->postJson(route('admin.post.store'))->assertRedirect(route('admin.post.edit', $post->id));
        $this->assertDatabaseCount('posts', 1);
    }

    public function testItUpdatesContentSuccessfully(): void
    {
        $post = PostFactory::new()->create();

        $data = ['id' => $post->id];
        foreach (locale()->supported() as $locale) {
            $data['title_' . $locale] = $this->faker->title;
            $data['content_' . $locale] = $this->faker->text;
        }

        $this
            ->putJson(route('admin.post.update.content', $post->id), $data)
            ->assertRedirect();

        $this->assertDatabaseHas('posts', $data);
    }

    public function testItUpdatesPreviewSuccessfully(): void
    {
        $post = PostFactory::new()->create();

        $data = ['id' => $post->id];
        foreach (locale()->supported() as $locale) {
            $data['short_title_' . $locale] = $this->faker->title;
            $data['short_content_' . $locale] = $this->faker->text;
        }

        $this
            ->putJson(route('admin.post.update.preview', $post->id), $data)
            ->assertRedirect();

        $this->assertDatabaseHas('posts', $data);
    }

    public function testItUpdatesCategorySuccessfully(): void
    {
        $post = PostFactory::new()->create();
        $postCategory = PostCategoryFactory::new()->create();
        $this
            ->putJson(route('admin.post.update.category', $post->id), ['post_category_id' => $postCategory->id])
            ->assertRedirect();

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'post_category_id' => $postCategory->id]);
    }

    public function testItUpdatesTagsSuccessfully(): void
    {
        $post = PostFactory::new()->create();
        $postTags = PostTagFactory::new()->count(3)->create();

        $this
            ->putJson(route('admin.post.update.tags', $post->id), ['tags' => $postTags->pluck('id')])
            ->assertRedirect();

        foreach ($postTags as $postTag) {
            $this->assertDatabaseHas('post_post_tag', ['post_id' => $post->id, 'post_tag_id' => $postTag->id]);
        }
    }

    public function testItUpdatesImageSuccessfully(): void
    {
        $name = GenerateFileName::execute('png');
        $post = PostFactory::new()->state([
            'picture' => $name,
        ])->create();

        $this
            ->putJson(route('admin.post.update.picture', $post->id), [
                'picture' => UploadedFile::fake()->image($name),
                'height' => 1920,
                'width' => 1080,
                'x1' => 1,
                'y1' => 1,
            ])
            ->assertRedirect();

        $post = $post->fresh();

        self::assertNotSame($post->picture, $name);
        Storage::assertExists(
            config('alphanews.media.filesystem.images_path') . '/' . $post->picture
        );
    }

    public function testItDestroysSuccessfully(): void
    {
        $post = PostFactory::new()->create();
        $this
            ->deleteJson(route('admin.post.destroy', $post->id))
            ->assertRedirect(route('admin.post.index'));
        $this->assertDatabaseEmpty('posts');
    }

    public function makeLocaleData(): array
    {
        $data = [];
        foreach (locale()->supported() as $locale) {
            $data['title_' . $locale] = null;
            $data['content_' . $locale] = null;
            $data['short_title_' . $locale] = null;
            $data['short_content_' . $locale] = null;
        }
        return $data;
    }
}
