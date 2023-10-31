@extends('admin::layouts.master')

@section('title')
    @if($faq->exists)
        {{$faq->id}}
        <button
            class="btn btn-danger ml-1"
            type="button"
            data-form-id="delete-faq"
            data-ask="1"
            data-title="Delete"
            data-confirm-button-color="danger"
            data-message="Delete FAQ ?"
            data-type="warning"
        >Delete
        </button>
    @else
        FAQ
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{route('admin.faq.index')}}">FAQs</a>
    </li>
    @if($faq->exists)
        <li class="breadcrumb-item active">{{$faq->id}}</li>
    @else
        <li class="breadcrumb-item active">Create</li>
    @endif
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if($faq->exists)
                            <h3 class="card-title">Edit</h3>
                        @else
                            <h3 class="card-title">Create</h3>
                        @endif
                    </div>
                    <form
                        action="{{
                                $faq->exists
                                ? route('admin.faq.update', $faq->id)
                                : route('admin.faq.store')
                                }}" method="post">

                        <div class="card-body">
                            @csrf
                            @if($faq->exists)
                                @method('PUT')
                            @endif

                            @foreach(locale()->supported() as $locale)
                                <div class="form-group">
                                    <label for="Question {{Str::upper($locale)}}">Question {{Str::upper($locale)}}</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="question_{{$locale}}"
                                        placeholder="Question {{Str::upper($locale)}}"
                                        value="{{$faq["question_$locale"]}}">
                                </div>
                                <div class="form-group">
                                    <label for="Answer {{Str::upper($locale)}}">Answer {{Str::upper($locale)}}</label>
                                    <textarea
                                        type="text"
                                        class="form-control"
                                        name="answer_{{$locale}}"
                                        placeholder="Answer {{Str::upper($locale)}}"
                                        maxlength="240"
                                    >{{$faq["answer_$locale"]}}</textarea>
                                </div>
                            @endforeach

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                @if($faq->exists)
                                    Update
                                @else
                                    Create
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if($faq->exists)
        <form
            action="{{route('admin.faq.destroy', $faq->id)}}"
            method="post"
            id="delete-faq"
        >
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection
