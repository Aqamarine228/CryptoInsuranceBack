@extends('admin::layouts.master')

@section('title')
    Edit post
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.post.index') }}">Posts</a></li>
    <li class="breadcrumb-item active">Edit</li>
@stop

@push('scripts')
    <script src="{{Module::asset('admin:plugins/tinymce/tinymce.min.js')}}"></script>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                    <h3 class="card-title">
                        Edit Content
                    </h3>
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#full-content" data-toggle="tab">Full Content</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#preview" data-toggle="tab">Preview</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content p-0">
                        <div class="chart tab-pane active" id="full-content">
                            @include('admin::post.blocks._content-form')
                        </div>
                        <div class="chart tab-pane" id="preview">
                            @include('admin::post.blocks._short-content-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            @include('admin::post.blocks._status')
            @include('admin::post.blocks._publish')
            @include('admin::post.blocks._category')
            @include('admin::post.blocks._tags')
            @include('admin::post.blocks._image')
        </div>
    </div>
    @include('admin::post.blocks._crop-image-modal')
@stop
