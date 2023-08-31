<?php

namespace Modules\Admin\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends \App\Models\Post
{
    protected $fillable = [
        'post_category_id', 'author_id', 'title_en', 'title_ru', 'short_content_en', 'short_content_ru',
        'short_title_en', 'short_title_ru', 'content_en', 'content_ru', 'picture', 'published_at', 'date_ico',
        'views', 'slug',
    ];

    protected array $dates = [
        'published_at'
    ];

    /**
     * Attributes
     */

    public function getPictureAttribute($value): string|null
    {
        return $value ? Storage::url(config('alphanews.media.filesystem.images_path') . '/' . $value) : null;
    }

    /**
     * Relations
     */

    public function author(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'author_id',
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            PostCategory::class,
            'post_category_id',
            'id',
        );
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            PostTag::class,
            'post_post_tag',
            'post_id',
            'post_tag_id',
        );
    }

    public function isPublished(): bool
    {
        return null !== $this->published_at;
    }

    public function isStep1Completed(): bool
    {
        return (bool)$this->post_category_id;
    }

    public function isStep2Completed(): bool
    {
        $title = true;
        foreach (locale()->supported() as $locale) {
            $title = $title && (bool)$this["title_$locale"];
        }
        return $title;
    }

    public function isStep3Completed(): bool
    {
        $short_title = true;
        foreach (locale()->supported() as $locale) {
            $short_title = $short_title && (bool)$this["short_title_$locale"];
        }
        return $short_title;
    }

    public function isStep4Completed(): bool
    {
        return (bool)$this->picture;
    }

    public function publishable(): bool
    {
        return $this->isStep1Completed()
            && $this->isStep2Completed()
            && $this->isStep3Completed()
            && $this->isStep4Completed();
    }
}
