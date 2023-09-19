<section class="main-slider clearfix">
    <div class="swiper-container thm-swiper__slider">
        <div class="swiper-wrapper">

            <div class="swiper-slide">
                <div class="image-layer"
                     style="background-image: url({{Module::asset('client:images/backgrounds/main-slider-1-1.jpg')}});">
                </div>

                <div class="main-slider-shape-1 float-bob-x">
                    <img src="{{Module::asset('client:images/shapes/main-slider-shape-1.png')}}" alt="">
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="main-slider__content">
                                <h2 class="main-slider__title">
                                    {{__('home.sliderTitle')}}
                                </h2>
                                <p class="main-slider__text">{{__('home.sliderDescription')}}</p>
                                <div class="main-slider__btn-box">
                                    <a href="about.html"
                                       class="thm-btn main-slider__btn">{{__('home.sliderGetStarted')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
