@extends('admin::layouts.master')

@section('title')
    @if($subscriptionOption->exists)
        {{$subscriptionOption->id}}
        <button
            class="btn btn-danger ml-1"
            type="button"
            data-form-id="delete-insurance-subscription-option"
            data-ask="1"
            data-title="Delete"
            data-confirm-button-color="danger"
            data-message="Delete insurance subscription option ?"
            data-type="warning"
        >Delete
        </button>
    @else
        Insurance Subscription Option
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{route('admin.insurance-subscription-option.index')}}">Insurance Subscription Options</a>
    </li>
    @if($subscriptionOption->exists)
        <li class="breadcrumb-item active">{{$subscriptionOption->id}}</li>
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
                        @if($subscriptionOption->exists)
                            <h3 class="card-title">Edit</h3>
                        @else
                            <h3 class="card-title">Create</h3>
                        @endif
                    </div>
                    <form
                        action="{{
                                $subscriptionOption->exists
                                ? route('admin.insurance-subscription-option.update', $subscriptionOption->id)
                                : route('admin.insurance-subscription-option.store')
                                }}" method="post">

                        <div class="card-body">
                            @csrf
                            @if($subscriptionOption->exists)
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="Duration In Days">Duration In Days</label>
                                <input
                                    type="number"
                                    step="1"
                                    class="form-control"
                                    name="days"
                                    placeholder="Duration In Days"
                                    value="{{$subscriptionOption->duration / 60 / 60 / 24}}"
                                    min="1"
                                >
                            </div>
                            <div class="form-group">
                                <label for="Sale Percentage">Sale Percentage</label>
                                <input
                                    type="number"
                                    step=".01"
                                    class="form-control"
                                    name="sale_percentage"
                                    placeholder="Sale Percentage"
                                    value="{{$subscriptionOption->sale_percentage}}"
                                    min="0"
                                    max="100"
                                >
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                @if($subscriptionOption->exists)
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
    @if($subscriptionOption->exists)
        <form
            action="{{route('admin.insurance-subscription-option.destroy', $subscriptionOption->id)}}"
            method="post"
            id="delete-insurance-subscription-option"
        >
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection
