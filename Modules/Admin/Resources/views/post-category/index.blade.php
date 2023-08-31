@extends('admin::layouts.master')

@section('title')
    Post Categories
    <a href="{{ route('admin.post-category.create', ['category_id' => request()->segment(3)]) }}"
       class="btn btn-sm btn-primary">Create</a>
@stop

@section('breadcrumb')
    <li class="breadcrumb-item">Post Categories</li>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">

        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Name {{Str::upper(locale()->default())}}</th>
                            <th>News count</th>
                            <th width="160px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>
                                    {{ $category['name_'.locale()->default()] }}
                                </td>
                                <td>
                                    {{ $category->posts_count }}
                                </td>

                                <td>
                                    <a href="{{ route('admin.post-category.edit', $category->id) }}"
                                       class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Edit</a>

                                    @if ($category->posts_count === 0)
                                        <button
                                            data-form-id="delete-category-{{ $category->id }}"
                                            class="btn btn-sm btn-danger"
                                            data-ask="1"
                                            data-title="Delete category"
                                            data-message="Are you sure you want to delete the category - '{{ $category->name }}'?"
                                            data-type="warning"
                                            data-confirm-button-color="danger"
                                        >
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                        <form id="delete-category-{{ $category->id }}"
                                              action="{{ route('admin.post-category.destroy', $category->id) }}"
                                              method="post">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>

@stop
