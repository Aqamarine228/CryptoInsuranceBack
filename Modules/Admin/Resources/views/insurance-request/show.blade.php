@extends('admin::layouts.master')

@section('title')
    {{$insuranceRequest->option['name_' . locale()->default()]}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('admin.insurance-request.index')}}">Insurance Requests</a></li>
    <li class="breadcrumb-item active">{{$insuranceRequest->option['name_' . locale()->default()]}}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <ul class="list-group list-group-unbordered mb-3">
                            @for($i=0; $i < $insuranceRequest->option->fields->count(); $i++)
                                <li class="list-group-item">
                                    <b>
                                        {{Str::title($insuranceRequest->option->fields[$i]['name_'.locale()->default()])}}
                                    </b>
                                    <a
                                        class="float-right">{{$insuranceRequest->fields[$i]['value'] ?? '-'}}
                                    </a>
                                </li>
                            @endfor
                            <li class="list-group-item">
                                <b>Coverage</b> <a class="float-right">{{$insuranceRequest->coverage}}$</a>
                            </li>
                            <li class="list-group-item">
                                <b>Request Created At</b> <a class="float-right">{{$insuranceRequest->created_at}}</a>
                            </li>
                            <div class="d-flex">
                                <button
                                    type="submit"
                                    class="btn btn-primary w-50 mr-1"
                                    data-form-id="approve-form"
                                    data-ask="1"
                                    data-title="Approve"
                                    data-confirm-button-color="primary"
                                    data-message="Approve insurance request?"
                                    data-type="warning"
                                >Approve
                                </button>
                                <a href="{{route('admin.insurance-request.reject', $insuranceRequest->id)}}"
                                   class="btn btn-danger w-50 ml-1">Reject</a>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{route('admin.insurance-request.approve', $insuranceRequest->id)}}"
          method="POST" id="approve-form">
        @csrf
    </form>
@endsection
