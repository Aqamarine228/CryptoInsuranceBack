<?php

namespace Modules\Admin\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Admin\Models\PostTag;

/**
 * class PostTagResource
 *
 * @mixin PostTag
 */
class PostTagResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name_en,
        ];
    }
}
