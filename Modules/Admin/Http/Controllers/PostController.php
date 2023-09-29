<?php

namespace Modules\Admin\Http\Controllers;

use App\Actions\GenerateFileName;
use App\Actions\GenerateSlug;
use App\Rules\AllLanguagesRule;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Modules\Admin\Components\Messages;
use Modules\Admin\Models\Post;

class PostController extends BaseAdminController
{
    public function index(): Renderable
    {
        $posts = Post::latest()->paginate();

        return $this->view('post.index', [
            'posts' => $posts
        ]);
    }

    public function edit(Post $post): Renderable
    {
        return $this->view('post.edit', [
            'post' => $post,
        ]);
    }

    public function updateContent(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'title' => new AllLanguagesRule('nullable', 'string'),
            'content' => new AllLanguagesRule('nullable', 'string'),
        ]);

        if (array_key_exists('title_' . locale()->default(), $validated)
            && $validated['title_' . locale()->default()]) {
            $validated['slug'] = GenerateSlug::execute($validated['title_' . locale()->default()]);
        }

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

    public function updatePicture(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'picture' => ['required', 'image', 'max:4096'],
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'x1' => 'required|numeric',
            'y1' => 'required|numeric'
        ]);

        $imageName = $this->cropAndUploadImage(
            $validated['picture'],
            $post,
        );

        if ($post->picture) {
            Storage::delete($post->getPicturePath());
        }

        $post->update([
            'picture' => $imageName
        ]);

        return back();
    }

    protected function cropAndUploadImage(UploadedFile $image): string
    {
        $fileName = GenerateFileName::execute('png');

        $image = Image::make($image)->crop(...array_values(request()->only(['width', 'height', 'x1', 'y1'])));

        $originalImage = $image->encode('png');

        Storage::put(
            Config::get('alphanews.media.filesystem.images_path') . '/' . $fileName,
            $originalImage->stream()
        );

        return $fileName;
    }

    public function store(): RedirectResponse
    {
        $post = $this->getEmptyPost();
        if ($post === null) {
            $post = Post::create();
        }

        return redirect()->route('admin.post.edit', $post->id);
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();
        Messages::success('Post deleted successfully');
        return redirect()->route('admin.post.index');
    }

    private function getEmptyPost(): Post|null
    {
        $postQuery = Post::whereNull('picture');

        foreach (locale()->supported() as $locale) {
            $postQuery = $postQuery
                ->whereNull('title_' . $locale)
                ->whereNull('content_' . $locale)
                ->whereNull('short_title_' . $locale)
                ->whereNull('short_content_' . $locale);
        }
        return $postQuery->latest()->first();
    }
}
