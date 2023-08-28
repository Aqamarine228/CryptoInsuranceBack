<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Intervention\Image\ImageManagerStatic;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Modules\Admin\Models\Image;
use Modules\Admin\Models\MediaFolder;

class ImageController extends \Modules\Admin\Http\Controllers\BaseAdminController
{
    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $fields = $this->validate(request(), [
            'media_folder_id' => 'required|exists:media_folders,id',
            'images.*' => 'required|image|max:5120',
        ]);

        foreach ($fields['images'] as $image) {
            $imageName = $this->uploadImage($image);

            Image::create([
                'media_folder_id' => $fields['media_folder_id'],
                'name' => $imageName
            ]);
        }

        return back();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ValidationException
     */
    public function storeFromTinymce(): array
    {
        $fields = $this->validate(request(), [
            'file' => 'required|image|max:5120',
        ]);

        $folderId = $this->getFolderId(request()->get('news_id'));

        $imageName = $this->uploadImage($fields['file']);

        $image = Image::create([
            'media_folder_id' => $folderId,
            'name' => $imageName
        ]);

        return [
            'location' => $image->getFullUrl()
        ];
    }

    private function getFolderId($newsId): int
    {
        return $newsId ? MediaFolder::firstOrCreate([
            'name' => $newsId,
            'media_folder_id' => Config::get('alphanews.media.folders.news'),
        ])->id : Config::get('alphanews.media.folders.news');
    }

    private function uploadImage(UploadedFile $image): string
    {
        $imageName = Str::random(10) . ' _ ' . time() . '.png';
        Storage::put(
            Config::get('alphanews.media.filesystem.images_path') . '/' . $imageName,
            ImageManagerStatic::make($image)->stream()
        );

        return $imageName;
    }
}
