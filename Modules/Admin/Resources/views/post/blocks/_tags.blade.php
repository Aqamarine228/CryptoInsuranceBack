<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tags</h3>
    </div>
    <div class="card-body">
        <form id="post-update-tags" action="{{ route('admin.post.update.tags', $post->id) }}" method="post">
            @csrf
            @method('put')
            <input type="hidden" name="step_method" value="updateStep5">
            <div class="form-group">
                <label for="Tags">Tags</label>
                <select id="tags" name="tags[]" class="w-100" multiple="multiple">
                    @foreach($post->tags as $tag)
                        <option value="{{$tag->id}}" selected>
                            {{$tag["name_".locale()->default()]}}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button form="post-update-tags" class="btn btn-primary">Update</button>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tags').select2({
                placeholder: 'Tags',
                ajax: {
                    url: '{{route('admin.post-tag.search')}}',
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
