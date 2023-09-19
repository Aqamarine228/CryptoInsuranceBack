<section class="services-one">
    <div class="services-one__top">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6">
                    <div class="services-one__top-left">
                        <div class="section-title text-left">
                            <div class="section-sub-title-box">
                                <p class="section-sub-title">{{__('home.servicesTitle')}}</p>
                                <div class="section-title-shape-1">
                                    <img src="{{Module::asset('client:images/shapes/section-title-shape-1.png')}}" alt="">
                                </div>
                                <div class="section-title-shape-2">
                                    <img src="{{Module::asset('client:images/shapes/section-title-shape-2.png')}}" alt="">
                                </div>
                            </div>
                            <h2 class="section-title__title">{{__('home.servicesSubTitle')}}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6">
                    <div class="services-one__top-right">
                        <p class="services-one__top-text">{{__('home.servicesDescription')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="services-one__bottom">
        <div class="services-one__container">
            <div class="row">
                @foreach($insuranceOptions as $insuranceOption)
                    <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="100ms">
                        <div class="services-one__single">
                            <div class="service-one__img">
                                <img src="{{$insuranceOption->picture}}" alt="">
                            </div>
                            <div class="service-one__content">
                                <h2 class="service-one__title">{{$insuranceOption->name}}</h2>
                                <p class="service-one__text">{{$insuranceOption->description}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
