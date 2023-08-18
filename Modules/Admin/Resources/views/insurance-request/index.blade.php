@extends('admin::layouts.master')

@section('title')
    Insurance Requests
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Insurance Requests</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Insurance Requests</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Insurance Option</th>
                                <th>Created At</th>
                                <th style="width: 100px">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($insuranceRequests as $insuranceRequest)
                                <tr>
                                    <td>{{$insuranceRequest->option['name_' . locale()->default()]}}</td>
                                    <td>{{$insuranceRequest->created_at}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm"
                                           href="{{route('admin.insurance-request.show', $insuranceRequest->id)}}">
                                            <i class="fas fa-eye"></i>
                                            Show
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{$insuranceRequests->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
