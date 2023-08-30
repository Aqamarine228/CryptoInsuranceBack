<?php

namespace Modules\Client\Models;

class PostCategory extends \App\Models\PostCategory
{

    protected array $localizable = [
        'name'
    ];

    /**
     * Scopes
     */

    public function scopeRoot($q)
    {
        return $q->whereNull('post_category_id');
    }

}
