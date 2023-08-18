@extends('admin::layouts.master')

@section('title')
    {{$referralRequest->user->first_name}} {{$referralRequest->user->last_name}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('admin.referral-request.index')}}">Referral Requests</a></li>
    <li class="breadcrumb-item active">{{ $referralRequest->user->email }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <img
                                class="img-fluid rounded"
                                src="{{ \Illuminate\Support\Facades\Storage::disk('private')->temporaryUrl(\Modules\ClientApi\Models\ReferralRequest::getDocumentPath($referralRequest->document_photo), now()->addMinute())  }}" alt="Photo">
                        </div>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Email</b> <a class="float-right">{{$referralRequest->user->email}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>First Name</b> <a class="float-right">{{$referralRequest->user->first_name}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Last Name</b> <a class="float-right">{{$referralRequest->user->last_name}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Address</b> <a class="float-right">{{$referralRequest->address}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Telegram</b> <a
                                    class="float-right"
                                    href="https://t.me/{{ $referralRequest->telegram_account }}">
                                    {{'@' . $referralRequest->telegram_account}}
                                </a>
                            </li>
                            <li class="list-group-item">
                                <b>Request Created At</b> <a class="float-right">{{$referralRequest->created_at}}</a>
                            </li>
                            @if($lastRejectionReason)
                                <strong class="mt-2">Last Rejection Reason</strong>
                                <p class="text-muted">
                                    {{$lastRejectionReason}}
                                </p>
                            @endif
                            <div class="d-flex">
                                <button
                                    type="submit"
                                    class="btn btn-primary w-50 mr-1"
                                    data-form-id="approve-form"
                                    data-ask="1"
                                    data-title="Approve"
                                    data-confirm-button-color="primary"
                                    data-message="Approve '{{$insuranceRequest->option['name_' . locale()->default()]}}' insurance request?"
                                    data-type="warning"
                                >Approve</button>
                                <a href="{{route('admin.referral-request.reject', $referralRequest->id)}}"
                                   class="btn btn-danger w-50 ml-1">Reject</a>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{route('admin.referral-request.approve', $referralRequest->id)}}"
          method="POST" id="approve-form">
        @csrf
    </form>
@endsection
