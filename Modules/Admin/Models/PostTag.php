<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class PostTag extends \App\Models\PostTag
{
    use Searchable;

    protected $fillable = ['name_en', 'name_ru', 'post_amount'];

    public function searchableAs(): string
    {
        return 'name_en';
    }

    /**
     * Relations
     */

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(
            Post::class,
        );
    }
}
