@extends('admin::layouts.master')

@section('title')
    Edit - {{ $postCategory['name_'.locale()->default()] }}
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.post-category.index') }}">Post Categories</a></li>
    <li class="breadcrumb-item active">Edit</li>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit</h3>
                </div>
                <div class="card-body">
                    @include('admin::post-category._form', [
                        'model' => $postCategory
                    ])
                </div>
            </div>
        </div>
    </div>

@stop
