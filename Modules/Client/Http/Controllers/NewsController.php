<?php

namespace Modules\Client\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Modules\Client\Models\Post;

class NewsController extends BaseClientController
{

    private const POSTS_PER_PAGE_COUNT = 5;
    private const LATEST_POSTS_COUNT = 3;

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

    public function show($locale, Post $post): Renderable
    {
        return $this->view('news.show', array_merge([
            'post' => $post,
        ], $this->getRequiredParameters()));
    }

    private function getRequiredParameters(): array
    {
        return [
            'latestPosts' => Post::published()->latest()->limit(self::LATEST_POSTS_COUNT)->get(),
        ];
    }
}
