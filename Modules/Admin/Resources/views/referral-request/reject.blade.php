@extends('admin::layouts.master')

@section('title')
    Reject {{$referralRequest->user->first_name}} {{$referralRequest->user->last_name}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('admin.referral-request.index')}}">Referral Requests</a></li>
    <li class="breadcrumb-item">
        <a href="{{route('admin.referral-request.reject', $referralRequest->id)}}">
            {{ $referralRequest->user->email }}
        </a>
    </li>
    <li class="breadcrumb-item active">Reject</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.referral-request.reject', $referralRequest->id) }}" method="post"
                              id="reject-form">
                            @csrf
                            <div class="form-group">
                                @foreach(locale()->supported() as $locale)
                                    <label>Rejection Reason {{Str::upper($locale)}}</label>
                                    <textarea class="form-control" rows="3" placeholder="Reason..."
                                              name="rejection_reason_{{$locale}}"  maxlength="200"></textarea>
                                @endforeach
                            </div>
                            <div class="d-flex">
                                <a href="{{ route('admin.referral-request.show', $referralRequest->id) }}"
                                   class="w-50 mr-1 btn btn-primary">Cancel</a>
                                <button
                                    class="btn btn-danger w-50 ml-1"
                                    type="button"
                                    data-form-id="reject-form"
                                    data-ask="1"
                                    data-title="Reject"
                                    data-confirm-button-color="danger"
                                    data-message="Reject '{{$referralRequest->user->email}}' user?"
                                    data-type="warning"
                                >Reject
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
