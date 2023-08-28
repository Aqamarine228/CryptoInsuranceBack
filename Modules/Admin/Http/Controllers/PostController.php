<?php

namespace Modules\Admin\Http\Controllers;

use App\Enums\PostMediaType;
use App\Rules\AllLanguagesRule;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Enum;
use Intervention\Image\ImageManagerStatic as Image;
use Modules\Admin\Components\Messages;
use Modules\Admin\Models\Post;

class PostController extends BaseAdminController
{
    public function index(Request $request): Renderable
    {
        $posts = Post::where('author_id', $request->user()->id)
            ->latest()
            ->paginate(20);

        return $this->view('post.index', [
            'posts' => $posts
        ]);
    }

    public function indexAllPosts(): Renderable
    {
        $posts = Post::latest()->paginate(20);

        return $this->view('post.index', [
            'posts' => $posts
        ]);
    }

    public function edit(Post $post): Renderable
    {
        $post->load('tags');
        $post->load('category');
        return $this->view('post.edit', [
            'post' => $post,
        ]);
    }

    public function mainPost(Post $post): RedirectResponse
    {
        if (!$post->isPublished()) {
            Messages::error('Can not make this News main because it is not published yet');
            return back();
        }

        DB::transaction(function () use ($post) {
            Post::where('is_trending_now', 1)->update(['is_trending_now' => false]);
            $post->update(['is_trending_now' => true]);
        });

        Messages::success($post->short_title . ' is the main post now');
        return back();
    }

    public function updateContent(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'title' => new AllLanguagesRule('nullable', 'string'),
            'content' => new AllLanguagesRule('nullable', 'string'),
        ]);

        $post->update($validated);

        return back();
    }

    public function updatePreview(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'short_title' => new AllLanguagesRule('nullable', 'string', 'max:255'),
            'short_content' => new AllLanguagesRule('nullable', 'string', 'max:255'),
        ]);

        $post->update($validated);

        return back();
    }

    public function updateCategory(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'post_category_id' => 'required|integer|exists:post_categories,id',
        ]);

        $post->update($validated);

        return back();
    }

    public function updateMediaType(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'media_type' => [
                'required',
                new Enum(PostMediaType::class)
            ]
        ]);

        $post->update($validated);

        return back();
    }

    public function updateImage(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'picture' => ['required', 'image', 'max:4096'],
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'x1' => 'required|numeric',
            'y1' => 'required|numeric'
        ]);

        $imageName = $this->cropAndUploadImagesByName(
            $validated['picture'],
            $post,
        );

        if ($post->picture) {
            Storage::delete(Config::get('alphanews.posts.filesystem.preview_images_path') . '/' . $post->picture);
        }

        $post->update([
            'picture' => $imageName
        ]);

        return back();
    }

    protected function cropAndUploadImagesByName(UploadedFile $image, Post $post): string
    {
        $fileName = $post->id . '_' . time() . '.png';

        $image = Image::make($image)->crop(...array_values(request()->only(['width', 'height', 'x1', 'y1'])));

        $originalImage = $image->encode('png');

        Storage::put(
            Config::get('alphanews.posts.filesystem.original_images_path') . '/' . $fileName,
            $originalImage->stream()
        );

        return $fileName;
    }

    public function updateTags(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'tags' => 'nullable|array',
            'tags.*' => 'required|string|max:255'
        ]);

        if (!array_key_exists('tags', $validated)) {
            $validated['tags'] = [];
        }

        $post->tags()->sync($validated['tags']);

        return back();
    }

    public function store(Request $request): RedirectResponse
    {
        $post = $this->getEmptyPost($request->user());
        if ($post === null) {
            $post = Post::create([
                'author_id' => $request->user()->id,
            ]);
        }

        return redirect()->route('admin.post.edit', $post->id);
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();
        Messages::success('Post deleted successfully');
        return redirect()->route('admin.posts.index');
    }

    private function getEmptyPost(mixed $user): Post|null
    {
        $emptyPost = Post::where('author_id', $user->id)
            ->whereNull('post_category_id')
            ->whereNull('title_en')
            ->whereNull('title_ru')
            ->whereNull('content_en')
            ->whereNull('content_ru')
            ->whereNull('short_title_en')
            ->whereNull('short_title_ru')
            ->whereNull('short_content_en')
            ->whereNull('short_content_ru')
            ->whereNull('picture')
            ->latest()
            ->first();

        if ($emptyPost !== null && $emptyPost->tags()->count() === 0) {
            return $emptyPost;
        }

        return null;
    }
}
