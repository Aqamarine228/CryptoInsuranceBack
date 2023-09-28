<?php

namespace Modules\ClientApi\Models;

use Illuminate\Support\Facades\Storage;

class Post extends \App\Models\Post
{

    protected array $localizable = ['short_content', 'short_title'];

    /**
     * Attributes
     */

    public function getPictureAttribute($value): string
    {
        return Storage::url(config('alphanews.media.filesystem.images_path') . '/' . $value);
    }
}
