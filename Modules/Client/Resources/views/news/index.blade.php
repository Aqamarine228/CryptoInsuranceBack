@extends('client::layouts.master')

@section('content')
    <section class="page-header">
        <div class="page-header-bg"
             style="background-image: url({{Module::asset('client:images/backgrounds/page-header-bg-2.jpg')}})">
        </div>
        <div class="page-header-shape-1"><img src="{{Module::asset('client:images/shapes/page-header-shape-1.png')}}"
                                              alt=""></div>
        <div class="container">
            <div class="page-header__inner">
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{route('client.home')}}">{{__('pages.home')}}</a></li>
                    <li><span>/</span></li>
                    <li>{{__('pages.news')}}</li>
                </ul>
                <h2>{{Str::ucfirst(__('pages.news'))}}</h2>
            </div>
        </div>
    </section>

    <section class="news-sidebar">
        <div class="container">
            <div class="row">
                @include('client::news._news')
                @include('client::news._sidebar')
            </div>
            @include('client::news._pagination')
        </div>
    </section>
@endsection
