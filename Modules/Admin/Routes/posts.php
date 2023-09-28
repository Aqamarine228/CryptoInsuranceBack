<?php

use Modules\Admin\Http\Controllers\ImageController;
use Modules\Admin\Http\Controllers\MediaFolderController;
use Modules\Admin\Http\Controllers\PostController;
use Modules\Admin\Http\Controllers\PublishPostController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth:admin'])
    ->group(function () {

        Route::prefix('/media-folder')->name('media-folder.')->group(function () {
            Route::post('/', [MediaFolderController::class, 'store'])->name('store');
            Route::get('/{mediaFolder?}', [MediaFolderController::class, 'index'])->name('index');
            Route::prefix('/images')->name('image.')->group(function () {
                Route::post('/tinymce', [ImageController::class, 'storeFromTinymce'])->name('store-from-tinymce');
                Route::post('/', [ImageController::class, 'store'])->name('store');
            });
        });

        Route::resource('post', PostController::class)->except('show', 'update');

        Route::prefix('/post')->name('post.')->group(function () {
            Route::prefix('/{post}')->group(function () {
                Route::put('/content', [PostController::class, 'updateContent'])->name('update.content');
                Route::put('/preview', [PostController::class, 'updatePreview'])->name('update.preview');
                Route::put('/media-type', [PostController::class, 'updateMediaType'])->name('update.media-type');
                Route::put('/picture', [PostController::class, 'updatePicture'])->name('update.picture');
                Route::post('/publish', [PublishPostController::class, 'publish'])->name('publish');
                Route::post('/unpublish', [PublishPostController::class, 'unPublish'])->name('unpublish');
            });
        });
    });
