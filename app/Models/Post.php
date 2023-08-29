<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $casts = [
        'published_at' => 'datetime',
        'is_trending_now' => 'boolean',
    ];
}
