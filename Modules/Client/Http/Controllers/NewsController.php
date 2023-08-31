<?php

namespace Modules\Client\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Client\Models\PostTag;
use Illuminate\Contracts\Support\Renderable;
use Modules\Client\Models\Post;
use Modules\Client\Models\PostCategory;

class NewsController extends BaseClientController
{

    private const POSTS_PER_PAGE_COUNT = 5;
    private const LATEST_POSTS_COUNT = 3;

    private const POPULAR_TAGS_COUNT = 10;

    public function index(): Renderable
    {
        $posts = Post::published()->latest()->paginate(self::POSTS_PER_PAGE_COUNT);

        return $this->view('news.index', array_merge([
            'posts' => $posts,
        ], $this->getRequiredParameters()));
    }

    public function search(Request $request): Renderable
    {
        $validated = $request->validate([
            'search' => 'required|string',
        ]);
        $posts = Post::search($validated['search'])->paginate(self::POSTS_PER_PAGE_COUNT);
        return $this->view('news.search', array_merge([
            'posts' => $posts,
        ], $this->getRequiredParameters()));
    }

    public function indexByTag($locale, PostTag $postTag): Renderable
    {
        $posts = $postTag->posts()->published()->latest()->paginate(self::POSTS_PER_PAGE_COUNT);

        return $this->view('news.tag', array_merge([
            'posts' => $posts,
            'tag' => $postTag,
        ], $this->getRequiredParameters()));
    }

    public function indexByCategory($locale, PostCategory $postCategory): Renderable
    {
        $posts = $postCategory->posts()->published()->latest()->paginate(self::POSTS_PER_PAGE_COUNT);

        return $this->view('news.category', array_merge([
            'posts' => $posts,
            'category' => $postCategory,
        ], $this->getRequiredParameters()));
    }

    public function show($locale, Post $post): Renderable
    {
        $post->load('tags');
        $post->load('category');

        return $this->view('news.show', array_merge([
            'post' => $post,
        ], $this->getRequiredParameters()));
    }

    private function getRequiredParameters(): array
    {
        return [
            'latestPosts' => Post::published()->latest()->limit(self::LATEST_POSTS_COUNT)->get(),
            'categories' => PostCategory::all(),
            'tags' => PostTag::popular()->limit(self::POPULAR_TAGS_COUNT)->get(),
        ];
    }
}
