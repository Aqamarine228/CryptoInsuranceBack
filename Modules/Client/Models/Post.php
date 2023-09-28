<?php

namespace Modules\Client\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;

class Post extends \App\Models\Post
{
    use Searchable;

    public function toSearchableArray(): array
    {
        return [
            'title_en' => $this->title_en,
            'title_ru' => $this->title_ru,
            'short_title_en' => $this->short_title_en,
            'short_title_ru' => $this->short_title_ru,
        ];
    }

    protected array $localizable = [
        'title',
        'content',
        'short_title',
        'short_content',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

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
