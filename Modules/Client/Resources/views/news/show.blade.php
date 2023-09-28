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
                    <li>{{$post->short_title}}</li>
                </ul>
                <h2>{{$post->short_title}}</h2>
            </div>
        </div>
    </section>

    <section class="news-details">
        <div class="container">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8 col-lg-7">
                            <div class="news-details__left">
                                <div class="news-details__img">
                                    <img src="{{$post->picture}}" alt="">
                                </div>
                                <div class="news-details__content">
                                    <ul class="list-unstyled news-details__meta">
                                        <li><a href="#"><i class="far fa-calendar"></i> {{$post->published_at}}</a></li>
                                    </ul>
                                    <h3 class="news-details__title">{{$post->title}}</h3>
                                    {!! $post->content !!}
                                </div>
                            </div>
                        </div>
                        @include('client::news._sidebar')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
