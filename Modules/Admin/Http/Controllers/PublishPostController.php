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
            $post->isStep1Completed() ?: Messages::error("Parent category is not selected");
            $post->isStep2Completed() ?: Messages::error("Post has no title");
            $post->isStep3Completed() ?: Messages::error("Post has no short title");
            $post->isStep4Completed() ?: Messages::error("Post has no picture");
            return back();
        }

        $validated = $request->validate([
            'date' => [
                'date_format:Y-m-d',
                'before_or_equal:' . date('Y-m-d'),
                'required'
            ]
        ]);

        DB::transaction(static function () use ($post, $validated) {
            $post->update([
                'published_at' => $validated['date']
            ]);
            $post->category()->increment('posts_amount');
            $post->tags()->increment('posts_amount');
        });

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

        DB::transaction(static function () use ($post) {
            $post->update([
                'published_at' => null
            ]);
            $post->category()->decrement('posts_amount');
            $post->tags()->decrement('posts_amount');
        });

        Messages::success('Post unpublished successfully');
        return back();
    }
}
