<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends \App\Models\Post
{
    protected $fillable = [
        'author_id', 'title_en', 'title_ru', 'short_content_en', 'short_content_ru',
        'short_title_en', 'short_title_ru', 'content_en', 'content_ru', 'picture', 'published_at', 'date_ico',
        'views', 'slug',
    ];

    protected array $dates = [
        'published_at'
    ];

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

    /**
     * Scopes
     */

    public function scopeEmpty($q)
    {
        foreach (locale()->supported() as $locale) {
            $q = $q
                ->whereNull('title_' . $locale)
                ->whereNull('content_' . $locale)
                ->whereNull('short_title_' . $locale)
                ->whereNull('short_content_' . $locale);
        }

        return $q
            ->whereNull('post_category_id')
            ->whereNull('picture');
    }

    /**
     * Methods
     */

    public function isPublished(): bool
    {
        return null !== $this->published_at;
    }

    public function hasTitle(): bool
    {
        $title = true;
        foreach (locale()->supported() as $locale) {
            $title = $title && (bool)$this["title_$locale"];
        }
        return $title;
    }

    public function hasContent(): bool
    {
        $content = true;
        foreach (locale()->supported() as $locale) {
            $content = $content && (bool)$this["content_$locale"];
        }
        return $content;
    }

    public function hasShortTitle(): bool
    {
        $shortTitle = true;
        foreach (locale()->supported() as $locale) {
            $shortTitle = $shortTitle && (bool)$this["short_title_$locale"];
        }
        return $shortTitle;
    }

    public function hasPicture(): bool
    {
        return (bool)$this->picture;
    }

    public function hasShortContent(): bool
    {
        $shortContent = true;
        foreach (locale()->supported() as $locale) {
            $shortContent = $shortContent && (bool)$this["short_content_$locale"];
        }
        return $shortContent;
    }

    public function publishable(): bool
    {
        return $this->hasTitle()
            && $this->hasShortTitle()
            && $this->hasContent()
            && $this->hasShortContent()
            && $this->hasPicture();
    }

    public function getPicturePath(): string
    {
        return config('alphanews.media.filesystem.images_path') . '/' . $this->picture;
    }
}
