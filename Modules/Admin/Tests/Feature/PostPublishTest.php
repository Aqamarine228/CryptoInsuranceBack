<?php

namespace Modules\Admin\Tests\Feature;

use App\Actions\GenerateFileName;
use App\Actions\GenerateSlug;
use Modules\Admin\Database\Factories\PostCategoryFactory;
use Modules\Admin\Database\Factories\PostFactory;
use Modules\Admin\Database\Factories\PostTagFactory;
use Modules\Admin\Tests\AdminTestCase;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;

class PostPublishTest extends AdminTestCase
{

    public function testItPublishesSuccessfully(): void
    {
        $post = PostFactory::new()->state($this->generateFullPost())->create();
        $post->tags()->sync(PostTagFactory::new()->count(2)->create()->pluck('id'));

        $this->postJson(route('admin.post.publish', $post->id), [
            'date' => now()->format('Y-m-d')
        ])->assertRedirect();

        assertNotNull($post->fresh()->published_at);
    }

    public function testCannotPublishPostWithoutTags(): void
    {
        $post = PostFactory::new()->state($this->generateFullPost())->create();
        $this->postJson(route('admin.post.publish', $post->id))->assertRedirect();
        assertNull($post->fresh()->published_at);
    }

    public function testCannotPublishPostWithoutCategory(): void
    {
        $data = $this->generateFullPost();
        $data['post_category_id'] = null;
        $post = PostFactory::new()->state($data)->create();
        $post->tags()->sync(PostTagFactory::new()->count(2)->create()->pluck('id'));
        $this->postJson(route('admin.post.publish', $post->id))->assertRedirect();
        assertNull($post->fresh()->published_at);
    }

    public function testCannotPublishPostWithoutPicture(): void
    {
        $data = $this->generateFullPost();
        $data['picture'] = null;
        $post = PostFactory::new()->state($data)->create();
        $post->tags()->sync(PostTagFactory::new()->count(2)->create()->pluck('id'));
        $this->postJson(route('admin.post.publish', $post->id))->assertRedirect();
        assertNull($post->fresh()->published_at);
    }

    public function testCannotPublishPostWithoutTitle(): void
    {
        $data = $this->generateFullPost();
        $data['title_'.locale()->default()] = null;
        $post = PostFactory::new()->state($data)->create();
        $post->tags()->sync(PostTagFactory::new()->count(2)->create()->pluck('id'));
        $this->postJson(route('admin.post.publish', $post->id))->assertRedirect();
        assertNull($post->fresh()->published_at);
    }

    public function testCannotPublishPostWithoutShortTitle(): void
    {
        $data = $this->generateFullPost();
        $data['short_title_'.locale()->default()] = null;
        $post = PostFactory::new()->state($data)->create();
        $post->tags()->sync(PostTagFactory::new()->count(2)->create()->pluck('id'));
        $this->postJson(route('admin.post.publish', $post->id))->assertRedirect();
        assertNull($post->fresh()->published_at);
    }

    public function testCannotPublishPostWithoutContent(): void
    {
        $data = $this->generateFullPost();
        $data['content_'.locale()->default()] = null;
        $post = PostFactory::new()->state($data)->create();
        $post->tags()->sync(PostTagFactory::new()->count(2)->create()->pluck('id'));
        $this->postJson(route('admin.post.publish', $post->id))->assertRedirect();
        assertNull($post->fresh()->published_at);
    }

    public function testCannotPublishPostWithoutShortContent(): void
    {
        $data = $this->generateFullPost();
        $data['short_content_'.locale()->default()] = null;
        $post = PostFactory::new()->state($data)->create();
        $post->tags()->sync(PostTagFactory::new()->count(2)->create()->pluck('id'));
        $this->postJson(route('admin.post.publish', $post->id))->assertRedirect();
        assertNull($post->fresh()->published_at);
    }

    public function testItUnpublishedSuccessfully(): void
    {
        $post = PostFactory::new()->state([
            'published_at' => now(),
        ])->create();

        $this->postJson(route('admin.post.unpublish', $post->id))->assertRedirect();
        assertNull($post->fresh()->published_at);
    }

    private function generateFullPost(): array
    {
        $data = [
            'picture' => GenerateFileName::execute('png'),
            'post_category_id' => PostCategoryFactory::new()->create()->id,
            'slug' => GenerateSlug::execute($this->faker->title),
        ];

        foreach (locale()->supported() as $locale) {
            $data['title_' . $locale] = $this->faker->title;
            $data['content_' . $locale] = $this->faker->text;
            $data['short_title_' . $locale] = $this->faker->title;
            $data['short_content_' . $locale] = $this->faker->text;
        }
        return $data;
    }

}
