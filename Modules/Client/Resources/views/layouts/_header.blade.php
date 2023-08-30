<header class="main-header clearfix">
    <div class="main-header__top">
        <div class="container">
            <div class="main-header__top-inner">
                <div class="main-header__top-address">
                    <ul class="list-unstyled main-header__top-address-list">
                        <li>
                            <i class="icon">
                                <span class="icon-pin"></span>
                            </i>
                            <div class="text">
                                <p>30 Commercial Road Fratton, Australia</p>
                            </div>
                        </li>
                        <li>
                            <i class="icon">
                                <span class="icon-email"></span>
                            </i>
                            <div class="text">
                                <p><a href="mailto:needhelp@company.com">needhelp@company.com</a></p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="main-header__top-right">
                    <div class="main-header__top-menu-box">
                        <ul class="list-unstyled main-header__top-menu">
                            @foreach(locale()->supported() as $locale)
                                <li>
                                    <a href="{{route(Route::current()->getName(), ['locale' => $locale])}}">
                                        {{Str::upper($locale)}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="main-header__top-social-box">
                        <div class="main-header__top-social">
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-pinterest-p"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="main-menu clearfix">
        <div class="main-menu__wrapper clearfix">
            <div class="container">
                <div class="main-menu__wrapper-inner clearfix">
                    <div class="main-menu__left">
                        <div class="main-menu__logo">
                            <a href="{{route('client.home')}}"><img
                                    src="{{Module::asset('client:images/resources/logo-1.png')}}"
                                    alt=""></a>
                        </div>
                        <div class="main-menu__main-menu-box">
                            <div class="main-menu__main-menu-box-inner">
                                <a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>
                                <ul class="main-menu__list">
                                    <li class="dropdown">
                                        <a href="#">Insurance </a>
                                        <ul>
                                            <li><a href="insurance-01.html">Insurance 01</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="{{route('client.news.index')}}">{{__('pages.news')}}</a>
                                    </li>
                                    <li>
                                        <a href="contact.html">{{__('pages.contacts')}}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="main-menu__main-menu-box-search-get-quote-btn">
                                <div class="main-menu__main-menu-box-search">
                                    <a href="#"
                                       class="main-menu__search search-toggler icon-magnifying-glass"></a>
                                    <a href="cart.html"
                                       class="main-menu__cart insur-two-icon-shopping-cart"></a>
                                </div>
                                <div class="main-menu__main-menu-box-get-quote-btn-box">
                                    <a href="contact.html"
                                       class="thm-btn main-menu__main-menu-box-get-quote-btn">Get a Quote</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-menu__right">
                        <div class="main-menu__call">
                            <div class="main-menu__call-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="main-menu__call-content">
                                <a href="tel:9200368090">+92 (003) 68-090</a>
                                <p>Call to Our Experts</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="stricky-header stricked-menu main-menu">
    <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
</div><!-- /.stricky-header -->

