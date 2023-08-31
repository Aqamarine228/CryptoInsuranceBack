<?php

namespace Modules\Client\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class PostCategory extends \App\Models\PostCategory
{

    protected array $localizable = [
        'name'
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Relations
     */

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
