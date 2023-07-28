@extends('admin::layouts.master')

@section('title')
    Referral Requests
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Referral Requests</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Referral Requests</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Email</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Telegram</th>
                                <th>Created At</th>
                                <th style="width: 100px">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($referralRequests as $referralRequest)
                                <tr>
                                    <td>{{$referralRequest->user->email}}</td>
                                    <td>{{$referralRequest->user->first_name}}</td>
                                    <td>{{$referralRequest->user->last_name}}</td>
                                    <td>
                                        <a href="https://t.me/{{ $referralRequest->telegram_account }}">
                                            {{'@' . $referralRequest->telegram_account}}
                                        </a>
                                    </td>
                                    <td>{{$referralRequest->created_at}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm"
                                           href="{{route('admin.referral-request.show', $referralRequest->id)}}">
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
                        {{ $referralRequests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
