<div class="card">
    <div class="card-header">
        Details
    </div>
    <div class="card-body">
        <div>
            <b> <em class="fa fa-eye"></em> Visibility:</b>
            @if ($post->isPublished())
                Visible
            @else
                Hidden
            @endif
        </div>
        <div>
            <strong> <em class="fas fa-fire"></em> On top: </strong>
            {{ $post->is_trending_now ? 'True' : 'False'}}
        </div>
        <div>
            <strong> <em class="fa fa-calendar-plus"></em> Created at:</strong>
            {{ $post->created_at->diffForHumans() }}
        </div>
        <div>
            <strong> <em class="fas fa-calendar-week"></em> Updated at:</strong>
            {{ $post->created_at->diffForHumans() }}
        </div>
        @if ($post->published_at !== null)
            <div>
                <strong> <em class="fa fa-calendar-check"></em> Published at:</strong>
                {{ $post->published_at->diffForHumans() }}
            </div>
        @endif

    </div>


    <div class="card-footer">
        <div class="row">
            <div class="col-md-6">
                <button form="post-destroy-{{ $post->id }}"
                        data-ask="1"
                        data-title="Delete post"
                        data-message="Are you sure you want to delete this post - '{{ $post->title }}'"
                        class="btn btn-outline-danger text-right">
                    Delete
                </button>
                <form id="post-destroy-{{ $post->id }}" action="{{ route('admin.post.destroy', $post->id) }}"
                      method="POST">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>

</div>
