@extends('admin::layouts.master')

@section('title')
    Create tag
@stop

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.post-tag.index') }}">Tags</a></li>
    <li class="breadcrumb-item active">Create</li>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.post-tag.store') }}" method="POST">

                        @csrf

                        @foreach(locale()->supported() as $locale)
                            <div class="form-group">
                                <label for="Name {{Str::upper($locale)}}">Name {{Str::upper($locale)}}</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="name_{{$locale}}"
                                    placeholder="Name {{Str::upper($locale)}}"
                                >
                            </div>
                        @endforeach

                        <button class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
