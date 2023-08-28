@extends('admin::layouts.master')

@section('title')
    Insurance Subscription Options
    <a class="btn btn-primary" href="{{route('admin.insurance-subscription-option.create')}}">Create</a>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Insurance Subscription Options</li>
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
                                <th>Duration</th>
                                <th>Sale Percentage</th>
                                <th style="width: 100px">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subscriptionOptions as $subscriptionOption)
                                <tr>
                                    <td>{{$subscriptionOption->duration / 60 / 60 / 24}} Days</td>
                                    <td>{{$subscriptionOption->sale_percentage}}%</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm"
                                           href="{{route('admin.insurance-subscription-option.edit', $subscriptionOption->id)}}">
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
                        {{ $subscriptionOptions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
