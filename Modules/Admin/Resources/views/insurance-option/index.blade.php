@extends('admin::layouts.master')

@section('title')
    Insurance Options
    <a class="btn btn-primary" href="{{route('admin.insurance-option.create')}}">Create</a>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Insurance Options</li>
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
                                <th style="width: 100px">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($insuranceOptions as $insuranceOption)
                                <tr>
                                    <td>{{$insuranceOption['name_' . locale()->default()]}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm"
                                           href="{{route('admin.insurance-option.edit', $insuranceOption->id)}}">
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
                        {{ $insuranceOptions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
