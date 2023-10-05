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
                    <li><a href="{{route('client.news.index')}}">{{__('pages.news')}}</a></li>
                    <li><span>/</span></li>
                    <li>{{__('news.searchFor')}}: '{{request()->get('search')}}'</li>
                </ul>
                <h2>{{__('news.searchFor')}}: "{{request()->get('search')}}"</h2>
            </div>
        </div>
    </section>

    <section class="news-sidebar">
        <div class="container">
            <div class="row">
                @if(!$posts->isEmpty())
                    @include('client::news._news')
                @else
                    <div class="col-xl-8 col-lg-7">
                        <div class="blog-sideabr__left">
                            <div id="primary" class="site-main">
                                <section class="no-results not-found error-page__inner text-center">
                                    <header class="not-found__page-header">
                                        <h2 class="page-title error-page__tagline">{{__('news.nothingFound')}}</h2>
                                    </header>
                                    <div class="not-found__page-content">
                                        <p class="error-page__text">{{__('news.nothingFoundText')}}</p>
                                        <div class="error-page__form">
                                            <div class="error-page__form-input">
                                                <form action="{{route('client.news.search')}}" class="error-page__form"
                                                      method="get">
                                                    <div class="error-page__form-input">
                                                        <input
                                                            type="search"
                                                            placeholder="Search here"
                                                            value="{{request()->get('search')}}"
                                                            name="search"
                                                        >
                                                        <button type="submit">
                                                            <i class="icon-magnifying-glass"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                @endif
                @include('client::news._sidebar')
            </div>
            @include('client::news._pagination')
        </div>
    </section>
@endsection
