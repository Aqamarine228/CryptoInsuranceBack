@extends('admin::layouts.master')

@section('title')
    Widget Variables
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Widget Variables</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Value</th>
                                <th style="width: 100px">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($variables as $variable)
                                <tr>
                                    <td>{{Str::title(str_replace('_', ' ', $variable->name))}}</td>
                                    <td>{{$variable->value}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm"
                                           href="{{route('admin.widget-variable.edit', $variable->id)}}">
                                            <i class="fas fa-pen"></i>
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{ $variables->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
