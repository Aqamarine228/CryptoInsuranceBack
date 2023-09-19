<footer class="site-footer">
    <div class="site-footer-bg"
         style="background-image: url({{Module::asset('client:images/backgrounds/site-footer-bg.png')}});">
    </div>
    <div class="container">
        <div class="site-footer__top">
            <div class="row d-flex" style="justify-content: center">
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                    <div class="footer-widget__column footer-widget__about">
                        <div class="footer-widget__logo">
                            <a href="{{route('client.home')}}"><img
                                    src="{{Module::asset('client:images/resources/footer-logo.png')}}"
                                    alt=""></a>
                        </div>
                        <div class="footer-widget__about-text-box">
                            <p class="footer-widget__about-text">{{__('footer.slogan')}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="200ms">
                    <div class="footer-widget__column footer-widget__contact clearfix">
                        <h3 class="footer-widget__title">{{__('footer.contact')}}</h3>
                        <ul class="footer-widget__contact-list list-unstyled clearfix">
                            <li>
                                <div class="icon">
                                    <span class="icon-email"></span>
                                </div>
                                <div class="text">
                                    <p><a href="mailto:needhelp@company.com">{{config('mail.support_email')}}</a></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-footer__bottom">
            <div class="row">
                <div class="col-xl-12">
                    <div class="site-footer__bottom-inner">
                        <p class="site-footer__bottom-text">© All Copyright 2023 by <a
                                href="{{route('client.home')}}">{{Str::title(config('client.company_name'))}}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
