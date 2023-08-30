<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class PostCategory extends \App\Models\PostCategory
{
    use Searchable;

    protected $fillable = ['name_en', 'name_ru', 'posts_amount', 'post_category_id', 'slug'];

    public function searchableAs(): string
    {
        return 'name_en';
    }

    /**
     * Relations
     */

    public function posts(): HasMany
    {
        return $this->hasMany(
            Post::class,
            'post_category_id',
            'id'
        );
    }

    public function childCategories(): HasMany
    {
        return $this->hasMany(
            self::class,
            'post_category_id',
            'id'
        );
    }

    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(self::class, 'post_category_id', 'id');
    }
}
