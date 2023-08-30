<?php

namespace Modules\Client\Http\Controllers;

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
        $latestPosts = Post::published()->latest()->limit(self::LATEST_POSTS_COUNT)->get();
        $categories = PostCategory::root()->get();
        $tags = PostTag::popular()->limit(self::POPULAR_TAGS_COUNT)->get();

        return $this->view('news.index', [
            'posts' => $posts,
            'latestPosts' => $latestPosts,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function show($locale, Post $post): Renderable
    {
        $latestPosts = Post::published()->latest()->limit(self::LATEST_POSTS_COUNT)->get();
        $categories = PostCategory::root()->get();
        $tags = PostTag::popular()->limit(self::POPULAR_TAGS_COUNT)->get();

        return $this->view('news.show', [
            'post' => $post,
            'latestPosts' => $latestPosts,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }
}
