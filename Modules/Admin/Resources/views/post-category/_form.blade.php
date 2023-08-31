<form
    action="{{ $model->exists ? route('admin.post-category.update', $model->id) : route('admin.post-category.store') }}"
    method="POST">

    @csrf
    @if ($model->exists)
        @method('PUT')
    @endif

    @foreach(locale()->supported() as $locale)
        <div class="form-group">
            <label for="Name {{Str::upper($locale)}}">Name {{Str::upper($locale)}}</label>
            <input
                type="text"
                class="form-control"
                name="name_{{$locale}}"
                placeholder="Name {{Str::upper($locale)}}"
                value="{{$model["name_$locale"]}}"
            >
        </div>
    @endforeach

    <button class="btn btn-primary">
        <em class="fa fa-save"></em>
        Save
    </button>
</form>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#parent').select2({
                placeholder: 'Parent Category',
                ajax: {
                    url: '{{route('admin.post-category.search')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            name: params.term,
                            current_id: {{$model->id ?? 'null'}},
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        })
    </script>
@endpush
