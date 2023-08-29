@extends('admin::layouts.master')

@section('title')
    Post Tags
    <a href="{{ route('admin.post-tag.create', ['tag_id' => request()->segment(3)]) }}" class="btn btn-sm btn-primary">Create</a>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item active">Post Tags</li>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered mb-4">
                        <thead>
                        <tr>
                            <th>Name {{Str::upper(locale()->default())}}</th>
                            <th>Posts</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tags as $tag)
                            <tr>
                                <td>{{ $tag['name_'.locale()->default()] }}</td>
                                <td>{{ $tag->posts_count }}</td>
                                <td>
                                    <button data-form-id="delete-tag-{{ $tag->id }}" class="btn btn-sm btn-danger"
                                            data-ask="1" data-title="Delete tag"
                                            data-message="Are you sure you want to delete the tag - '{{ $tag->name }}'?"
                                            data-type="warning"
                                    ><i class="fas fa-trash"></i> Delete
                                    </button>

                                    <form id="delete-tag-{{ $tag->id }}"
                                          action="{{ route('admin.post-tag.destroy', $tag->id) }}"
                                          method="post">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $tags->links() }}
                </div>
            </div>
        </div>
    </div>

@stop
