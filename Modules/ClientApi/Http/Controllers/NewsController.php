<?php

namespace Modules\ClientApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\ClientApi\Http\Resources\PostResource;
use Modules\ClientApi\Models\Post;

class NewsController extends BaseClientApiController
{

    const NEWS_PER_PAGE_COUNT = 3;

    public function index(): JsonResponse
    {
        return $this->respondSuccess(PostResource::collection(Post::published()->latest()->paginate(self::NEWS_PER_PAGE_COUNT)));
    }

    public function show(Post $post): JsonResponse
    {
        return $this->respondSuccess(new PostResource($post));
    }
}
