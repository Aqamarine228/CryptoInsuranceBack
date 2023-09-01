<?php

namespace Modules\Client\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Modules\Client\Models\Post;

class HomeController extends BaseClientController
{

    private const POSTS_PER_PAGE_COUNT = 3;

    public function __invoke(): Renderable
    {
        return $this->view('home.home', [
            'posts' => $this->getNews(),
        ]);
    }

    private function getNews(): Collection
    {
        return Post::published()->latest()->with('category')->limit(self::POSTS_PER_PAGE_COUNT)->get();
    }
}
