<?php

namespace Modules\ClientApi\Models;

use Illuminate\Support\Facades\Storage;

class Post extends \App\Models\Post
{

    protected array $localizable = ['short_content', 'short_title'];

    /**
     * Scopes
     */

    public function scopePublished($q)
    {
        return $q->whereNotNull('published_at');
    }

    /**
     * Attributes
     */

    public function getPictureAttribute($value): string
    {
        return Storage::url(config('alphanews.media.filesystem.images_path') . '/' . $value);
    }
}
