<div class="card">
    <div class="card-header">
        <h3 class="card-title">Media Type</h3>
    </div>
    <div class="card-body">
        <form id="post-update-media" action="{{ route('admin.post.update.media-type', $post->id) }}" method="post">
            @csrf
            @method('put')

            <div class="form-group">
                <label for="Media Type">Media Type</label>
                <select id="media_type" name="media_type" class="w-100">
                    @foreach(\App\Enums\PostMediaType::array() as $key=>$value)
                        <option value="{{$key}}" {{$post->media_type === $key ? 'selected': ''}}>
                            {{$value}}
                        </option>
                    @endforeach
                </select>
            </div>

        </form>
    </div>
    <div class="card-footer">
        <button form="post-update-media" class="btn btn-primary">Save</button>
    </div>
</div>

@push('scripts')
    <script>
        $('#media_type').select2();
        $('.select2-selection').css('height', '40px');
    </script>
@endpush
