<form action="{{ route('admin.post.update.content', $post->id) }}" method="post">
    @csrf
    @method('put')

    @foreach(locale()->supported() as $locale)
        <div class="form-group">
            <label for="Title {{Str::upper($locale)}}">Title {{Str::upper($locale)}}</label>
            <input
                type="text"
                class="form-control"
                name="title_{{$locale}}"
                placeholder="Title {{Str::upper($locale)}}"
                value="{{$post["title_$locale"]}}"
            >
        </div>
        <div class="form-group">
            <label for="Content {{Str::upper($locale)}}">Content {{Str::upper($locale)}}</label>
            <textarea
                type="text"
                class="form-control"
                name="content_{{$locale}}"
                id="{{"content_$locale"}}"
                placeholder="Content {{Str::upper($locale)}}"
            >
                {{$post["content_$locale"]}}
            </textarea>
        </div>
    @endforeach

    <button class="btn btn-primary">Save</button>

</form>

@push('scripts')
    <script>
        let contentPlugins = [
            "textcolor colorpicker advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor charactercount autosave preview code",
            "stylebuttons"
        ];
        let contentToolbar = "fontsizeselect | insertfile undo redo | style-h1 | blockquote | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | media fullpage | forecolor | preview | glossary";

        @foreach(locale()->supported() as $locale)
        initTinymce('#content_{{$locale}}', '300', contentToolbar, contentPlugins, {sourceId: {{ $post->id }}, folderId: 2});
        @endforeach
    </script>
@endpush
