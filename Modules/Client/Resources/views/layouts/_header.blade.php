<header class="main-header clearfix">
    <div class="main-header__top">
        <div class="container">
            <div class="main-header__top-inner">
                <div class="main-header__top-address">
                    <ul class="list-unstyled main-header__top-address-list">
                        <li>
                            <i class="icon">
                                <span class="icon-email"></span>
                            </i>
                            <div class="text">
                                <p>
                                    <a href="mailto:{{config('mail.support_email')}}">{{config('mail.support_email')}}</a>
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="main-header__top-right">
                    <div class="main-header__top-menu-box">
                        <ul class="list-unstyled main-header__top-menu">
                            <li>
                                <a href="{{config('frontend.login_link')}}">{{__('header.login')}}</a>
                            </li>
                            <li style="margin-right: 50px">
                                <a href="{{config('frontend.register_link')}}">{{__('header.register')}}</a>
                            </li>
                            @foreach(locale()->supported() as $locale)
                                <li>
                                    <a href="{{route(Route::current()->getName(), array_merge(
                                        request()->route()->parameters,
                                        ['locale' => $locale],
                                    )) . str_replace(request()->url(), '',request()->fullUrl())}}">
                                        {{Str::upper($locale)}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    {{--                    <div class="main-header__top-social-box">--}}
                    {{--                        <div class="main-header__top-social">--}}
                    {{--                            <a href="#"><i class="fab fa-twitter"></i></a>--}}
                    {{--                            <a href="#"><i class="fab fa-facebook"></i></a>--}}
                    {{--                            <a href="#"><i class="fab fa-pinterest-p"></i></a>--}}
                    {{--                            <a href="#"><i class="fab fa-instagram"></i></a>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
    <nav class="main-menu clearfix d-flex" style="justify-content: center">
        <div class="main-menu__wrapper clearfix">
            <div class="container">
                <div class="main-menu__wrapper-inner clearfix">
                    <div class="main-menu__left" style="display: flex">
                        <div class="main-menu__logo">
                            <a href="{{route('client.home')}}"><img
                                    src="{{Module::asset('client:images/resources/logo-1.png')}}"
                                    alt=""></a>
                        </div>
                        <div class="main-menu__main-menu-box">
                            <div class="main-menu__main-menu-box-inner">
                                <a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>
                                <ul class="main-menu__list">
                                    <li>
                                        <a href="{{route('client.home')}}">{{__('pages.home')}}</a>
                                    </li>
                                    <li>
                                        <a href="{{route('client.news.index')}}">{{__('pages.news')}}</a>
                                    </li>
                                    <li>
                                        <a href="{{route('client.about')}}">{{__('pages.about')}}</a>
                                    </li>
                                    <li>
                                        <a href="{{route('client.contact')}}">{{__('pages.contact')}}</a>
                                    </li>
                                    <li class="only-mobile">
                                        <a href="{{config('frontend.login_link')}}">{{__('header.login')}}</a>
                                    </li>
                                    <li class="only-mobile">
                                        <a href="{{config('frontend.register_link')}}">{{__('header.register')}}</a>
                                    </li>
                                    <li class="locale">
                                        @foreach(locale()->supported() as $locale)
                                            <a href="{{route(Route::current()->getName(), array_merge(
                                        request()->route()->parameters,
                                        ['locale' => $locale],
                                    )) . str_replace(request()->url(), '',request()->fullUrl())}}">
                                                {{Str::upper($locale)}}
                                            </a>
                                        @endforeach
                                    </li>
                                </ul>
                            </div>
                            <div class="main-menu__main-menu-box-search-get-quote-btn">
                                <div class="main-menu__main-menu-box-get-quote-btn-box">
                                    <a href="{{config('frontend.register_link')}}"
                                       class="thm-btn main-menu__main-menu-box-get-quote-btn">
                                        {{__('header.getStarted')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="stricky-header stricked-menu main-menu">
    <div class="sticky-header__content d-flex" style="justify-content: center"></div><!-- /.sticky-header__content -->
</div><!-- /.stricky-header -->

@push('style')
    .locale {
    display: none;}
    @media (max-width: 1199px) {k
    .locale {
    display: none;
    }
    }
@endpush
