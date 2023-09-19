<?php

namespace Modules\Client\Models;

use Illuminate\Support\Facades\Storage;

class InsuranceOption extends \App\Models\InsuranceOption
{

    protected array $localizable = ['name', 'description'];

    /**
     * Scopes
     */

    public function scopeDisplayable($q)
    {
        return $q->whereNotNull('picture');
    }

    /**
     * Attributes
     */

    public function getPictureAttribute($value): string
    {
        return Storage::url(config('alphanews.media.filesystem.images_path') . '/' . $value);
    }

}
