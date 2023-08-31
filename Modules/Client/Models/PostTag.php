<?php

namespace Modules\Client\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Client\Models\Post;

class PostTag extends \App\Models\PostTag
{

    protected array $localizable = [
        'name'
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scopes
     */

    public function scopePopular($q)
    {
        return $q->withCount(['posts' => fn ($q) => $q->published()])->orderBy('posts_count', 'desc');
    }

    /**
     * Relations
     */

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
