<?php

namespace Modules\ClientApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ClientApi\Models\Post;

/**
 * class PostResource
 *
 * @mixin Post
 */
class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->short_title,
            'slug' => $this->slug,
            'picture' => $this->picture,
            'created_at' => $this->created_at,
        ];
    }
}
