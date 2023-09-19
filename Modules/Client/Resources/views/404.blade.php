@extends('client::layouts.master')

@section('content')
    <section class="error-page">
        <div class="error-page-shape-1 float-bob-y"
             style="background-image: url({{Module::asset('client:images/shapes/error-page-shape-1.png')}});">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="error-page__inner">
                        <div class="error-page__title-box">
                            <h2 class="error-page__title">404</h2>
                            <h3 class="error-page__sub-title">{{__('404.pageTitle')}}!</h3>
                        </div>
                        <p class="error-page__text">{{__('404.text')}}</p>
                        <br/>
                        <a href="{{route('client.home')}}" class="thm-btn error-page__btn">{{__('404.backHomeButton')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
