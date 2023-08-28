<div class="card">
    <div class="card-header">
        <h3 class="card-title">Category</h3>
    </div>
    <div class="card-body">
        <form id="post-update-category" action="{{ route('admin.post.update.category', $post->id) }}" method="post">
            @csrf
            @method('put')

            <div class="form-group">
                <label for="Price">Category</label>
                <select id="category" name="post_category_id" class="w-100">
                    @if($post->post_category_id)
                        <option value="{{$post->post_category_id}}" selected>
                            {{$post->category["name_".locale()->default()]}}
                        </option>
                    @endif
                </select>
            </div>

        </form>
    </div>
    <div class="card-footer">
        <button form="post-update-category" class="btn btn-primary">Save</button>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#category').select2({
                placeholder: 'Category',
                ajax: {
                    url: '{{route('admin.post-category.search')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            name: params.term,
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
