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
                    <li>{{__('pages.news')}}</li>
                </ul>
                <h2>{{Str::ucfirst(__('pages.news'))}}</h2>
            </div>
        </div>
    </section>

    <section class="news-sidebar">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="news-sideabr__left">
                        <div class="news-sideabr__content">
                            @foreach($posts as $post)
                                <div class="news-sideabr__single">
                                    <div class="news-sideabr__img">
                                        <img src="{{$post->picture}}"
                                             alt="Post Preview">
                                    </div>
                                    <div class="news-sideabr__content-box">
                                        <ul class="list-unstyled news-sideabr__meta">
                                            <li>
                                                <a href="{{route('client.news.show', ['locale' => locale()->current(), 'post' => $post->id])}}">
                                                    <i class="far fa-calendar"></i>
                                                    {{$post->published_at}}
                                                </a>
                                            </li>
                                        </ul>
                                        <h3 class="news-sideabr__title">
                                            <a href="{{route('client.news.show', ['locale' => locale()->current(), 'post' => $post->id])}}">
                                                {{$post->short_title}}
                                            </a>
                                        </h3>
                                        <p class="news-sideabr__text">{!! $post->short_content !!}</p>
                                        <div class="news-sideabr__bottom-btn-box">
                                            <a href="{{route('client.news.show', ['locale' => locale()->current(), 'post' => $post->id])}}"
                                               class="news-sideabr__btn thm-btn">{{__('news.readMore')}}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @include('client::news._sidebar')
            </div>
            <div class="row pt-5">
                <div class="col-lg-12">
                    <div class="blog-pagination">
                        {{$posts->links()}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
