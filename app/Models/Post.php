<?php

namespace App\Models;

class Post extends LocalizableModel
{

    protected $casts = [
        'published_at' => 'date',
        'is_trending_now' => 'boolean',
    ];
}
