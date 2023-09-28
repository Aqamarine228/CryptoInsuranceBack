<section class="news-one">
    <div class="container">
        <div class="section-title text-center">
            <div class="section-sub-title-box">
                <p class="section-sub-title">{{__('home.newsFeed')}}</p>
                <div class="section-title-shape-1">
                    <img src="{{Module::asset('client:images/shapes/section-title-shape-1.png')}}" alt="">
                </div>
                <div class="section-title-shape-2">
                    <img src="{{Module::asset('client:images/shapes/section-title-shape-2.png')}}" alt="">
                </div>
            </div>
            <h2 class="section-title__title">{{__('home.latestNews')}} <br> {{__('home.latestNewsBolded')}}</h2>
        </div>
        <div class="row">
            @foreach($posts as $post)
                <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="100ms">
                    <div class="news-one__single">
                        <div class="news-one__img">
                            <img src="{{$post->picture}}" alt="">
                            <div class="news-one__arrow-box">
                                <a href="{{route('client.news.show', $post->slug)}}" class="news-one__arrow">
                                    <span class="icon-right-arrow1"></span>
                                </a>
                            </div>
                        </div>
                        <div class="news-one__content">
                            <ul class="list-unstyled news-one__meta">
                                <li><a href="{{route('client.news.show', $post->slug)}}"><i class="far fa-calendar"></i>
                                        {{$post->published_at}}</a>
                                </li>
                            </ul>
                            <h3 class="news-one__title">
                                <a href="{{route('client.news.show', $post->slug)}}">{{$post->short_title}}</a>
                            </h3>
                            <p class="news-one__text">{!! $post->short_content !!}</p>
                            <div class="news-one__read-more">
                                <a href="{{route('client.news.show', $post->slug)}}">
                                    {{__('home.readMore')}} <i class="fas fa-angle-double-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
