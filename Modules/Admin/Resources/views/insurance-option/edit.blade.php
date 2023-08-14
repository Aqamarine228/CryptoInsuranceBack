@extends('admin::layouts.master')

@section('title')
    @if($insuranceOption->exists)
        {{$insuranceOption['name_en']}}
        <button
            class="btn btn-danger ml-1"
            type="button"
            data-form-id="delete-insurance-option"
            data-ask="1"
            data-title="Delete"
            data-confirm-button-color="danger"
            data-message="Delete '{{$insuranceOption['name_en']}}' insurance option ?"
            data-type="warning"
        >Delete
        </button>
    @else
        Insurance Option
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('admin.insurance-option.index')}}">Insurance Options</a></li>
    @if($insuranceOption->exists)
        <li class="breadcrumb-item active">{{$insuranceOption['slug']}}</li>
    @else
        <li class="breadcrumb-item active">Create</li>
    @endif
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if($insuranceOption->exists)
                            <h3 class="card-title">Edit</h3>
                        @else
                            <h3 class="card-title">Create</h3>
                        @endif
                    </div>
                    <form
                        action="{{
                                $insuranceOption->exists
                                ? route('admin.insurance-option.update', $insuranceOption->id)
                                : route('admin.insurance-option.store')
                                }}" method="post">

                        <div class="card-body">
                            @csrf
                            @if($insuranceOption->exists)
                                @method('PUT')
                            @endif

                            <div class="form-group">
                                <label for="Name EN">Name EN</label>
                                <input type="text" class="form-control" name="name_en" placeholder="Name EN"
                                       value="{{$insuranceOption['name_en']}}">
                            </div>
                            <div class="form-group">
                                <label for="Description EN">Description EN</label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    name="description_en"
                                    placeholder="Description EN"
                                    maxlength="240"
                                >{{$insuranceOption['description_en']}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="Name RU">Name RU</label>
                                <input type="text" class="form-control" name="name_ru" placeholder="Name RU"
                                       value="{{$insuranceOption['name_ru']}}">
                            </div>
                            <div class="form-group">
                                <label for="Description RU">Description RU</label>
                                <textarea
                                    type="text"
                                    class="form-control"
                                    name="description_ru"
                                    placeholder="Description RU"
                                    maxlength="240"
                                >{{$insuranceOption['description_ru']}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="Price">Price</label>
                                <input type="number" step=".01" class="form-control" name="price" placeholder="Price"
                                       value="{{$insuranceOption->price}}">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                @if($insuranceOption->exists)
                                    Update
                                @else
                                    Create
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if($insuranceOption->exists)
        <form
            action="{{route('admin.insurance-option.destroy', $insuranceOption->id)}}"
            method="post"
            id="delete-insurance-option"
        >
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection
