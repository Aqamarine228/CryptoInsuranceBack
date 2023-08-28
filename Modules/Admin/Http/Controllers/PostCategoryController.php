<?php

namespace Modules\Admin\Http\Controllers;

use App\Rules\AllLanguagesRule;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Admin\Components\Messages;
use Modules\Admin\Http\Resources\PostCategoryResource;
use Modules\Admin\Models\PostCategory;

class PostCategoryController extends BaseAdminController
{
    const ITEMS_PER_SEARCH = 10;

    public function index(?PostCategory $postCategory): Renderable
    {
        $postCategories = PostCategory::where(
            'post_category_id',
            $postCategory?->id
        )
            ->withCount('childCategories')
            ->withCount(['posts'])
            ->latest()
            ->paginate();

        return $this->view('post-category.index', [
            'categories' => $postCategories,
            'rootCategory' => $postCategory,
        ]);
    }

    public function create(): Renderable
    {
        return $this->view('post-category.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'post_category_id' => 'nullable|exists:post_categories,id',
            'name' => new AllLanguagesRule('required', 'string', 'max:255', 'unique:post_categories'),
        ]);
        PostCategory::create($validated);
        Messages::success('Category successfully created.');

        return redirect()->route('admin.post-category.index');
    }

    public function edit(PostCategory $postCategory): Renderable
    {
        $postCategory->load('parentCategory');
        return $this->view('post-category.edit', [
            'postCategory' => $postCategory,
        ]);
    }

    public function update(Request $request, PostCategory $postCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => new AllLanguagesRule('required', 'string', 'max:255'),
        ]);

        try {
            $postCategory->update($validated);
        } catch (UniqueConstraintViolationException) {
            Messages::error('All names must be unique');
            return back();
        }

        Messages::success('Category successfully updated.');

        return back();
    }

    public function destroy(PostCategory $postCategory): RedirectResponse
    {
        if ($postCategory->posts()->exists()) {
            Messages::error('Can not delete category with posts');
        } elseif ($postCategory->childCategories()->exists()) {
            Messages::error('Can not delete parent category');
        } else {
            $postCategory->delete();
            Messages::success('Category successfully deleted');
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
            $categories = PostCategory::search($validated['name'])->take(self::ITEMS_PER_SEARCH)->get();
        } else {
            $categories = PostCategory::take(self::ITEMS_PER_SEARCH)->get();
        }

        if (array_key_exists('current_id', $validated)) {
            $categories = $categories->filter(function ($value) use ($validated) {
                return $value['id'] !== $validated['current_id'];
            });
        }

        return new JsonResponse(PostCategoryResource::collection($categories));
    }
}
