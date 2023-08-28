<?php

namespace Modules\Admin\Models;

use Illuminate\Support\Facades\Storage;

class Image extends \App\Models\Image
{
    protected $fillable = ['media_folder_id', 'name'];

    /**
    * Methods
    */

    public function getFullUrl(): string
    {
        return Storage::url(config('alphanews.media.filesystem.images_path') . '/' . $this->name);
    }
}
