<?php

namespace Modules\Admin\Tests\Feature;

use App\Actions\GenerateFileName;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\Database\Factories\PostFactory;
use Modules\Admin\Tests\AdminTestCase;

class PostTest extends AdminTestCase
{

    public function testItCreatesSuccessfully(): void
    {
        $this->postJson(route('admin.post.store'))->assertRedirect();

        $data = [
            'picture' => null,
            'published_at' => null,
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
