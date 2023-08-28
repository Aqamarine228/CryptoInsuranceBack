<form action="{{ route('admin.post.update.preview', $post->id) }}" method="post">
    @csrf
    @method('put')
    @foreach(locale()->supported() as $locale)
        <div class="form-group">
            <label for="Short Title {{Str::upper($locale)}}">Short Title {{Str::upper($locale)}}</label>
            <input
                type="text"
                class="form-control"
                name="short_title_{{$locale}}"
                placeholder="Short Title {{Str::upper($locale)}}"
                value="{{$post["short_title_$locale"]}}"
            >
        </div>
        <div class="form-group">
            <label for="Short Content {{Str::upper($locale)}}">Short Content {{Str::upper($locale)}}</label>
            <textarea
                type="text"
                class="form-control"
                name="short_content_{{$locale}}"
                id="{{"short_content_$locale"}}"
                placeholder="Short Content {{Str::upper($locale)}}"
            >{{$post["short_content_$locale"]}}</textarea>
        </div>
    @endforeach

    <button class="btn btn-primary">Next</button>

</form>

@push('scripts')
    <script>
        let plugins = [
            "textcolor colorpicker advlist autolink link lists charmap preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor charactercount",
            "stylebuttons"
        ];
        let toolbar = "style-h1 | insertfile undo redo | bold italic preview media fullpage | forecolor backcolor ";

        @foreach(locale()->supported() as $locale)
        initTinymce('#short_content_{{$locale}}', '200', toolbar, plugins, {sourceId: {{ $post->id }}, folderId: 2});
        @endforeach

    </script>
@endpush
