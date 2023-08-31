@extends('client::layouts.master')

@section('content')
    <section class="page-header">
        <div class="page-header-bg"
             style="background-image: url({{Module::asset('client:images/backgrounds/page-header-bg.jpg')}})">
        </div>
        <div class="page-header-shape-1"><img src="{{Module::asset('client:images/shapes/page-header-shape-1.png')}}"
                                              alt=""></div>
        <div class="container">
            <div class="page-header__inner">
                <ul class="thm-breadcrumb list-unstyled">
                    <li><a href="{{route('client.home')}}">{{__('pages.home')}}</a></li>
                    <li><span>/</span></li>
                    <li><a href="{{route('client.news.index')}}">{{__('pages.news')}}</a></li>
                    <li><span>/</span></li>
                    <li>{{$tag->name}}</li>
                </ul>
                <h2>{{trans_choice('news.tag', 1)}}: {{Str::ucfirst($tag->name)}}</h2>
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
