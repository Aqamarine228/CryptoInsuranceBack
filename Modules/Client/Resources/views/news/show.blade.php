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
                    <li><a href="{{route('client.news.index')}}">{{__('pages.news')}}</a></li>
                    <li><span>/</span></li>
                    <li>{{$post->short_title}}</li>
                </ul>
                <h2>{{$post->title}}</h2>
            </div>
        </div>
    </section>

    <section class="news-details">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="news-details__left">
                    </div>
                </div>
            </div>
            @include('client::news._sidebar')
        </div>
    </section>
@endsection
