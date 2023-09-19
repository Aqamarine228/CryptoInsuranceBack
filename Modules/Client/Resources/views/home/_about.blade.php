<section class="about-one">
    <div class="about-one-bg wow slideInRight" data-wow-delay="100ms" data-wow-duration="2500ms"
         style="background-image: url({{Module::asset('client:images/backgrounds/about-one-bg.jpg')}});"></div>
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="about-one__left">
                    <div class="about-one__img-box wow slideInLeft" data-wow-delay="100ms"
                         data-wow-duration="2500ms">
                        <div class="about-one__img">
                            <img src="{{Module::asset('client:images/resources/about-one-img-1.jpg')}}" alt="">
                        </div>
                        <div class="about-one__img-two">
                            <img src="{{Module::asset('client:images/resources/about-one-img-2.jpg')}}" alt="">
                        </div>
                        <div class="about-one__experience">
                            <p class="about-one__experience-text">{{__('home.aboutBadge')}}</p>
                        </div>
                        <div class="about-one__shape-1">
                            <img src="{{Module::asset('client:images/shapes/about-one-shape-1.jpg')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="about-one__right">
                    <div class="section-title text-left">
                        <div class="section-sub-title-box">
                            <p class="section-sub-title">{{__('home.aboutTitle')}}</p>
                            <div class="section-title-shape-1">
                                <img src="{{Module::asset('client:images/shapes/section-title-shape-1.png')}}" alt="">
                            </div>
                            <div class="section-title-shape-2">
                                <img src="{{Module::asset('client:images/shapes/section-title-shape-2.png')}}" alt="">
                            </div>
                        </div>
                        <h2 class="section-title__title">{{__('home.aboutQuote')}}</h2>
                    </div>
                    <p class="about-one__text-1">{{__('home.aboutSubTitle')}}</p>
                    <ul class="list-unstyled about-one__points">
                        <li>
                            <div class="icon">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="text">
                                <p>{{__('home.aboutBenefits1')}}</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="text">
                                <p>{{__('home.aboutBenefits2')}}</p>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="text">
                                <p>{{__('home.aboutBenefits3')}}</p>
                            </div>
                        </li>
                    </ul>
                    <p class="about-one__text-2">{{__('home.aboutDescription')}}</p>
                    <div class="about-one__btn-call">
                        <div class="about-one__btn-box">
                            <a href="{{route('client.about')}}"
                               class="thm-btn about-one__btn">{{__('home.aboutDiscoverMore')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
