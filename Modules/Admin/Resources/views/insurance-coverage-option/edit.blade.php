@extends('admin::layouts.master')

@section('title')
    @if($coverageOption->exists)
        {{$coverageOption->id}}
        <button
            class="btn btn-danger ml-1"
            type="button"
            data-form-id="delete-insurance-coverage-option"
            data-ask="1"
            data-title="Delete"
            data-confirm-button-color="danger"
            data-message="Delete insurance coverage option ?"
            data-type="warning"
        >Delete
        </button>
    @else
        Insurance Coverage Option
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{route('admin.insurance-coverage-option.index')}}">Insurance Coverage Options</a>
    </li>
    @if($coverageOption->exists)
        <li class="breadcrumb-item active">{{$coverageOption->id}}</li>
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
                        @if($coverageOption->exists)
                            <h3 class="card-title">Edit</h3>
                        @else
                            <h3 class="card-title">Create</h3>
                        @endif
                    </div>
                    <form
                        action="{{
                                $coverageOption->exists
                                ? route('admin.insurance-coverage-option.update', $coverageOption->id)
                                : route('admin.insurance-coverage-option.store')
                                }}" method="post">

                        <div class="card-body">
                            @csrf
                            @if($coverageOption->exists)
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="Coverage">Coverage</label>
                                <input
                                    type="number"
                                    step=".01"
                                    class="form-control"
                                    name="coverage"
                                    placeholder="Coverage"
                                    value="{{$coverageOption->coverage}}"
                                >
                            </div>
                            <div class="form-group">
                                <label for="Price Percentage">Price Addition Percentage</label>
                                <input
                                    type="number"
                                    step=".01"
                                    class="form-control"
                                    name="price_percentage"
                                    placeholder="Price Percentage"
                                    value="{{$coverageOption->price_percentage}}"
                                    min="0"
                                    max="100"
                                >
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                @if($coverageOption->exists)
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
    @if($coverageOption->exists)
        <form
            action="{{route('admin.insurance-coverage-option.destroy', $coverageOption->id)}}"
            method="post"
            id="delete-insurance-coverage-option"
        >
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection
