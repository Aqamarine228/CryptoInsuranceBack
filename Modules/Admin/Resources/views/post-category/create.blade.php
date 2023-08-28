@extends('admin::layouts.master')

@section('title')
    Create post category
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.post-category.index') }}">Post Categories</a></li>
    <li class="breadcrumb-item active">Create</li>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('admin::post-category._form', [
                        'model' => new \Modules\Admin\Models\PostCategory
                    ])
                </div>
            </div>
        </div>
    </div>

@stop
