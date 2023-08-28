<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Modules\Admin\Models\Image;
use Modules\Admin\Models\MediaFolder;

class MediaFolderController extends \Modules\Admin\Http\Controllers\BaseAdminController
{
    public function index(?MediaFolder $mediaFolder): Factory|View|Application
    {
        $subFolders = MediaFolder::where(
            'media_folder_id',
            $mediaFolder?->id
        )->paginate();
        $images = Image::where('media_folder_id', $mediaFolder?->id)->get();

        return $this->view('media-folder.index', [
            'rootFolder' => $mediaFolder,
            'subFolders' => $subFolders,
            'images' => $images,
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(): RedirectResponse
    {
        // deny for advert folder
        $validated = $this->validate(request(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('media_folders')->where(function ($query) {
                $query->where(
                    'media_folder_id',
                    request()->get('media_folder_id')
                );
            })],
            'media_folder_id' => 'nullable|exists:media_folders,id'
        ]);

        MediaFolder::create([
            'name' => $validated['name'],
            'media_folder_id' => $validated['media_folder_id'] ?? null
        ]);

        return back();
    }
}
