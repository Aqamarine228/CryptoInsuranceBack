<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Modules\Admin\Components\Messages;
use Throwable;
use Modules\Admin\Models\Post;

class PublishPostController extends BaseAdminController
{
    public function publish(Request $request, Post $post): RedirectResponse
    {
        if ($post->isPublished()) {
            Messages::error('Post is already published');
            return back();
        }

        if (!$post->publishable()) {
            Messages::error("Post is not publishable because:");
            $post->hasCategory() ?: Messages::error("Parent category is not selected");
            $post->hasTitle() ?: Messages::error("Not all titles are filled");
            $post->hasShortTitle() ?: Messages::error("Not all short titles are filled");
            $post->hasPicture() ?: Messages::error("Post has no picture");
            $post->hasTags() ?: Messages::error("Post has no selected tags");
            $post->hasContent() ?: Messages::error("Not all content fields are filled");
            $post->hasShortContent() ?: Messages::error("Not all short content fields are filled");
            return back();
        }

        $validated = $request->validate([
            'date' => [
                'date_format:Y-m-d',
                'before_or_equal:' . date('Y-m-d'),
                'required'
            ]
        ]);

        $post->update([
            'published_at' => $validated['date']
        ]);

        Messages::success('Post published successfully');
        return back();
    }

    /**
     * @throws Throwable
     */
    public function unPublish(Post $post): RedirectResponse
    {
        if (!$post->isPublished()) {
            Messages::error('Cannot un publish not published post');
            return back();
        }

        $post->update([
            'published_at' => null
        ]);

        Messages::success('Post unpublished successfully');
        return back();
    }
}
