@extends('admin::layouts.master')

@section('title')
    Reject {{$insuranceRequest->option['name_' . locale()->default()]}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('admin.insurance-request.index')}}">Insurance Requests</a></li>
    <li class="breadcrumb-item">
        <a href="{{route('admin.insurance-request.reject', $insuranceRequest->id)}}">
            {{$insuranceRequest->option['name_' . locale()->default()]}}
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
                        <form action="{{ route('admin.insurance-request.reject', $insuranceRequest->id) }}" method="post"
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
                                <a href="{{ route('admin.insurance-request.show', $insuranceRequest->id) }}"
                                   class="w-50 mr-1 btn btn-primary">Cancel</a>
                                <button
                                    class="btn btn-danger w-50 ml-1"
                                    type="button"
                                    data-form-id="reject-form"
                                    data-ask="1"
                                    data-title="Reject"
                                    data-confirm-button-color="danger"
                                    data-message="Reject '{{$insuranceRequest->option['name_' . locale()->default()]}}' insurance request?"
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
