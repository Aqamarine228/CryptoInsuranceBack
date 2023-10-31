@extends('admin::layouts.master')

@section('title')
    FAQs
    <a class="btn btn-primary" href="{{route('admin.faq.create')}}">Create</a>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">FAQs</li>
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
                                <th>Question</th>
                                <th style="width: 90px">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($faqs as $faq)
                                <tr>
                                    <td>{{$faq->question_en}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm"
                                           href="{{route('admin.faq.edit', $faq->id)}}">
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
                        {{ $faqs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
