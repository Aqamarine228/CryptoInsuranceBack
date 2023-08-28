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

    <div class="form-group">
        <label for="Price">Parent Category</label>
        <select id="parent" name="post_category_id" class="w-100" {{$model->exists ? 'disabled' : ''}}>
            @if($model->post_category_id)
                <option value="{{$model->post_category_id}}" selected>
                    {{$model->parentCategory["name_".locale()->default()]}}
                </option>
            @endif
        </select>
    </div>

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
