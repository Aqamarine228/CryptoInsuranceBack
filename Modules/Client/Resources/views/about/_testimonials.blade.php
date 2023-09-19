<section class="testimonial-two">
    <div class="testimonial-two-shape-1"
         style="background-image: url({{Module::asset('client:images/shapes/testimonial-two-shape-1.png')}});"></div>
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="testimonial-two__left">
                    <div class="section-title text-left">
                        <div class="section-sub-title-box">
                            <p class="section-sub-title">{{__('about.testimonialsTitle')}}</p>
                            <div class="section-title-shape-1">
                                <img src="{{Module::asset('client:images/shapes/section-title-shape-1.png')}}" alt="">
                            </div>
                            <div class="section-title-shape-2">
                                <img src="{{Module::asset('client:images/shapes/section-title-shape-2.png')}}" alt="">
                            </div>
                        </div>
                        <h2 class="section-title__title">{{__('about.testimonialsSubTitle')}}</h2>
                    </div>
                    <p class="testimonial-two__text">{{__('about.testimonialsDescription')}}</p>
                    <div class="testimonial-two__point-box">
                        <ul class="list-unstyled testimonial-two__point">
                            <li>
                                <div class="icon">
                                    <span class="icon-tick"></span>
                                </div>
                                <div class="text">
                                    <p>{{__('about.testimonialsBenefits1')}}<br></p>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <span class="icon-tick"></span>
                                </div>
                                <div class="text">
                                    <p>{{__('about.testimonialsBenefits2')}}<br></p>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-unstyled testimonial-two__point testimonial-two__point-two">
                            <li>
                                <div class="icon">
                                    <span class="icon-tick"></span>
                                </div>
                                <div class="text">
                                    <p>{{__('about.testimonialsBenefits3')}}<br></p>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <span class="icon-tick"></span>
                                </div>
                                <div class="text">
                                    <p>{{__('about.testimonialsBenefits4')}}<br></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="testimonial-two__right">
                    <div class="owl-carousel owl-theme thm-owl__carousel testimonial-two__carousel"
                         data-owl-options='{
                                "loop": true,
                                "autoplay": true,
                                "margin": 0,
                                "nav": false,
                                "dots": true,
                                "smartSpeed": 500,
                                "autoplayTimeout": 10000,
                                "navText": ["<span class=\"fa fa-angle-left\"></span>","<span class=\"fa fa-angle-right\"></span>"],
                                "responsive": {
                                    "0": {
                                        "items": 1
                                    },
                                    "768": {
                                        "items": 1
                                    },
                                    "992": {
                                        "items": 1
                                    },
                                    "1200": {
                                        "items": 1
                                    }
                                }
                            }'>
                        @for($i = 1; $i < 7; $i+=2)
                            <div class="testimonial-two__wrap">
                                <div class="testimonial-two__single">
                                    <div class="testimonial-two__single-inner">
                                        <div class="testimonial-two-shape-2">
                                            <img
                                                src="{{Module::asset('client:images/shapes/testimonial-two-shape-2.png')}}"
                                                alt="">
                                        </div>
                                        <div class="testimonial-two__content-box">
                                            <h5 class="testimonial-two__client-name">{{__("about.testimonialsReview{$i}Name")}}</h5>
                                            <p class="testimonial-two__text-2">{{__("about.testimonialsReview{$i}Text")}}</p>
                                        </div>
                                        <div class="testimonial-two__client-review">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                    <div class="testimonial-two__founder-box">
                                        <div class="testimonial-two__founder">
                                            <p class="testimonial-two__founder-text">{{__("about.testimonialsReview{$i}JobTitle")}}</p>
                                            <div class="testimonial-two__founder-shape">
                                                <img
                                                    src="{{Module::asset('client:images/shapes/testimonial-two-founder-shape.png')}}"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="testimonial-two__client-img-box">
                                            <div class="testimonial-two__client-img">
                                                <img
                                                    src="{{Module::asset("client:images/testimonial/testimonial-3-$i.jpg")}}"
                                                    alt="">
                                            </div>
                                            <div class="testimonial-two__quote">
                                                <img
                                                    src="{{Module::asset("client:images/testimonial/testimonial-1-quote.png")}}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="testimonial-two__single">
                                    <div class="testimonial-two__single-inner">
                                        <div class="testimonial-two-shape-2">
                                            <img
                                                src="{{Module::asset('client:images/shapes/testimonial-two-shape-2.png')}}"
                                                alt="">
                                        </div>
                                        <div class="testimonial-two__content-box">
                                            <h5 class="testimonial-two__client-name">{{__("about.testimonialsReview".$i+1 ."Name")}}</h5>
                                            <p class="testimonial-two__text-2">{{__("about.testimonialsReview".$i+1 ."Text")}}</p>
                                        </div>
                                        <div class="testimonial-two__client-review">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                    <div class="testimonial-two__founder-box">
                                        <div class="testimonial-two__founder">
                                            <p class="testimonial-two__founder-text">{{__("about.testimonialsReview".$i+1 ."JobTitle")}}</p>
                                            <div class="testimonial-two__founder-shape">
                                                <img
                                                    src="{{Module::asset('client:images/shapes/testimonial-two-founder-shape.png')}}"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="testimonial-two__client-img-box">
                                            <div class="testimonial-two__client-img">
                                                <img
                                                    src="{{Module::asset("client:images/testimonial/testimonial-3-".$i+1 .".jpg")}}"
                                                    alt="">
                                            </div>
                                            <div class="testimonial-two__quote">
                                                <img
                                                    src="{{Module::asset("client:images/testimonial/testimonial-1-quote.png")}}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
