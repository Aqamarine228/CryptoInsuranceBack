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
                    <li>{{__('pages.about')}}</li>
                </ul>
                <h2>{{__('pages.about')}}</h2>
            </div>
        </div>
    </section>
    @include('client::about._about-company')
    @include('client::about._testimonials')
    @include('client::components._counter')
@endsection
