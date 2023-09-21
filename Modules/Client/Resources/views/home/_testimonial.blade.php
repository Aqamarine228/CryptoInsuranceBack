<section class="testimonial-one">
    <div class="testimonial-one-shape-2 float-bob-y">
        <img src="{{Module::asset('client:images/shapes/testimonial-one-shape-2.png')}}" alt="">
    </div>
    <div class="testimonial-one-shape-3 float-bob-y">
        <img src="{{Module::asset('client:images/shapes/testimonial-one-shape-3.png')}}" alt="">
    </div>
    <div class="container">
        <div class="testimonial-one__top">
            <div class="row">
                <div class="col-xl-6">
                    <div class="testimonial-one__top-left">
                        <div class="section-title text-left">
                            <div class="section-sub-title-box">
                                <p class="section-sub-title">{{__('home.testimonialTitle')}}</p>
                                <div class="section-title-shape-1">
                                    <img src="{{Module::asset('client:images/shapes/section-title-shape-1.png')}}"
                                         alt="">
                                </div>
                                <div class="section-title-shape-2">
                                    <img src="{{Module::asset('client:images/shapes/section-title-shape-2.png')}}"
                                         alt="">
                                </div>
                            </div>
                            <h2 class="section-title__title">{{__('home.testimonialSubTitle')}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="testimonial-one__bottom">
            <div class="row">
                <div class="col-xl-12">
                    <div class="owl-carousel owl-theme thm-owl__carousel testimonial-one__carousel"
                         data-owl-options='{
                                "loop": true,
                                "autoplay": true,
                                "margin": 30,
                                "nav": false,
                                "dots": false,
                                "smartSpeed": 500,
                                "autoplayTimeout": 10000,
                                "navText": ["<span class=\"fa fa-angle-left\"></span>","<span class=\"fa fa-angle-right\"></span>"],
                                "responsive": {
                                    "0": {
                                        "items": 1
                                    },
                                    "768": {
                                        "items": 2
                                    },
                                    "992": {
                                        "items": 2
                                    },
                                    "1200": {
                                        "items": 2
                                    }
                                }
                            }'>
                        @for($i =1; $i < 5;$i++)
                            <div class="item">
                                <div class="testimonial-one__single">
                                    <div class="testimonial-one__single-inner">
                                        <div class="testimonial-one__shape-1">
                                            <img
                                                @if($i === 4)
                                                    src="{{Module::asset("client:images/shapes/testimonial-one-shape-1.png")}}"
                                                @else
                                                    src="{{Module::asset("client:images/shapes/testimonial-one-shape-$i.png")}}"
                                                @endif
                                                alt="">
                                        </div>
                                        <div class="testimonial-one__client-info">
                                            <div class="testimonial-one__client-img-box">
                                                <img
                                                    src="{{Module::asset("client:images/testimonial/testimonial-1-$i.jpg")}}"
                                                    alt="">
                                                <div class="testimonial-one__quote">
                                                    <img
                                                        src="{{Module::asset("client:images/testimonial/testimonial-1-quote.png")}}"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="testimonial-one__client-content">
                                                <div class="testimonial-one__client-review">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                                <div class="testimonial-one__client-details">
                                                    <h3 class="testimonial-one__client-name">{{__("home.testimonial{$i}Name")}}</h3>
                                                    <p class="testimonial-one__client-sub-title">{{__("home.testimonial{$i}JobTitle")}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="testimonial-one__text">{{__("home.testimonial{$i}Review")}}</p>
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
