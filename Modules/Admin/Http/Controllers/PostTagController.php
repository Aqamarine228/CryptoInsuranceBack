<?php

namespace Modules\Admin\Http\Controllers;

use App\Actions\GenerateSlug;
use App\Rules\AllLanguagesRule;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Admin\Components\Messages;
use Modules\Admin\Http\Resources\PostTagResource;
use Modules\Admin\Models\PostTag;

class PostTagController extends BaseAdminController
{
    const ITEMS_PER_SEARCH = 10;

    public function index(): Renderable
    {
        $tags = PostTag::withCount('posts')->orderBy('posts_count', 'desc')->paginate();

        return $this->view('post-tag.index', [
            'tags' => $tags,
        ]);
    }

    public function create(): Renderable
    {
        return $this->view('post-tag.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => new AllLanguagesRule('required', 'string', 'max:255', 'unique:post_tags'),
        ]);
        $validated['slug'] = GenerateSlug::execute($validated['name_' . locale()->default()]);

        PostTag::create($validated);
        Messages::success('Tag successfully created.');

        return redirect()->route('admin.post-tag.index');
    }

    public function destroy(PostTag $postTag): RedirectResponse
    {
        if (!$postTag->posts()->exists()) {
            $postTag->delete();
            Messages::success('Tag successfully deleted');
        } else {
            Messages::error('Can not delete tag with posts');
        }

        return back();
    }

    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'string|nullable|max:255',
            'current_id' => 'nullable|numeric|exists:post_categories,id',
        ]);

        if (array_key_exists('name', $validated) && $validated['name']) {
            $tags = PostTag::search($validated['name'])->take(self::ITEMS_PER_SEARCH)->get();
        } else {
            $tags = PostTag::take(self::ITEMS_PER_SEARCH)->get();
        }

        return new JsonResponse(PostTagResource::collection($tags));
    }
}
