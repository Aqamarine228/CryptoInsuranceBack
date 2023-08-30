<?php

namespace App\Actions;

use Illuminate\Support\Str;

class GenerateSlug
{

    public static function execute(string $key): string
    {
        return Str::slug($key) . "_" . now()->format('u');
    }
}
