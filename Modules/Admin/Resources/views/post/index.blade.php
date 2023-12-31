@extends('admin::layouts.master')

@section('title')
    <div class="d-flex">
        Posts
        <form class="ml-1" action="{{route('admin.post.store')}}" method="post">
            @csrf
            <button type="submit" class="btn btn-sm btn-primary">Create</button>
        </form>
    </div>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item active">Posts</li>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered mb-4">
                        <thead>
                        <tr>
                            <th width="144">Picture</th>
                            <th>Title {{Str::upper(locale()->default())}}</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th width="90"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr style="text-align: center">
                                <td><img src="{{Storage::url($post->getPicturePath())}}" width="144px" height="81px" alt="Post Image"></td>
                                <td style="vertical-align: middle">{{ $post['title_'.locale()->default()] ?? '-' }}</td>
                                <td style="vertical-align: middle">{{ $post->category['name_'.locale()->default()] ?? '' }}</td>
                                <td style="vertical-align: middle">
                                    @if ($post->published_at === null)
                                        <span class="badge badge-warning">Not published</span>
                                    @else
                                        <span class="badge badge-success">Published</span>
                                    @endif
                                </td>
                                <td style="vertical-align: middle">
                                    @include('admin::post.blocks._actions')
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
<script>
    $(document).ready(function () {
        //option A
        $("button[data-ask=1]").click(function (e, params) {
            var localParams = params || {};
            if (!localParams.send) {
                e.preventDefault();
            }
            var button = this;
            let type = $(button).data('type') ? $(this).data('type') : 'warning';

            Swal.fire({
                title: $(button).data('title'),
                text: $(button).data('message'),
                icon: type,
                input: $(this).data('input') ? $(this).data('input') : false,
                showCancelButton: true,
                confirmButtonColor: "#1e88e5",
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel',
                // closeOnConfirm: false,
                // closeOnCancel: false,
                showLoaderOnConfirm: true,
                preConfirm: function (amount) {
                    if (amount && $(button).data('form-id')) {
                        let formId = $(button).data('form-id');
                        let inputName = $(button).data('input-name');
                        $('#' + formId + ' input[name = ' + inputName + ']').val(amount);
                    }
                    $(button).trigger('click', {send: true});
                },
                // allowOutsideClick: () => !swal.isLoading()
            });
        });
    });
</script>
@endpush
