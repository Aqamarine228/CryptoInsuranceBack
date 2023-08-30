<?php

namespace Modules\Client\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Post extends \App\Models\Post
{

    protected array $localizable = [
        'title',
        'content',
        'short_title',
        'short_content',
    ];

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

    public function getPublishedAtAttribute($value): string
    {
        return Carbon::parse($value)->format('M d, Y');
    }

    public function getPictureAttribute($value): string
    {
        return Storage::url(config('alphanews.media.filesystem.images_path') . '/' . $value);
    }
}
