<?php

use Modules\Admin\Http\Controllers\ImageController;
use Modules\Admin\Http\Controllers\MediaFolderController;
use Modules\Admin\Http\Controllers\PostCategoryController;
use Modules\Admin\Http\Controllers\PostController;
use Modules\Admin\Http\Controllers\PublishPostController;
use Modules\Admin\Http\Controllers\PostTagController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth:admin'])
    ->group(function () {
        Route::resource('post-tag', PostTagController::class)->except('show', 'edit', 'update');
        Route::get('/post-tag/search', [PostTagController::class, 'search'])
            ->name('post-tag.search');

        Route::resource('post-category', PostCategoryController::class)->except('show', 'index');
        Route::get('/post-category/search', [PostCategoryController::class, 'search'])
            ->name('post-category.search');
        Route::get('/post-category/{postCategory?}', [PostCategoryController::class, 'index'])
            ->name('post-category.index');

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
                Route::put('/category', [PostController::class, 'updateCategory'])->name('update.category');
                Route::put('/media-type', [PostController::class, 'updateMediaType'])->name('update.media-type');
                Route::put('/tags', [PostController::class, 'updateTags'])->name('update.tags');
                Route::put('/image', [PostController::class, 'updateImage'])->name('update.image');
                Route::post('/publish', [PublishPostController::class, 'publish'])->name('publish');
                Route::post('/unpublish', [PublishPostController::class, 'unPublish'])->name('unpublish');
            });
        });
    });
