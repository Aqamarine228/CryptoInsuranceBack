@extends('admin::layouts.master')

@section('title')
    {{Str::title(str_replace('_', ' ', $variable->name))}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{route('admin.widget-variable.index')}}">Widget Variables</a>
    </li>
    <li class="breadcrumb-item active">{{Str::title(str_replace('_', ' ', $variable->name))}}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit</h3>
                    </div>
                    <form
                        action="{{route('admin.widget-variable.update', $variable->id)}}" method="post">
                        <div class="card-body">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="Sale Percentage">Value</label>
                                <input
                                    type="number"
                                    step=".01"
                                    class="form-control"
                                    name="value"
                                    placeholder="Value"
                                    value="{{$variable->value}}"
                                >
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                    Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
