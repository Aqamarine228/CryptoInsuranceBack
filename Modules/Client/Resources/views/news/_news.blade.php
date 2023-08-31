<div class="col-xl-8 col-lg-7">
    <div class="news-sideabr__left">
        <div class="news-sideabr__content">
            @foreach($posts as $post)
                <div class="news-sideabr__single">
                    <div class="news-sideabr__img">
                        <a href="{{route('client.news.show', ['post' => $post->slug])}}">
                            <img src="{{$post->picture}}"
                                 alt="Post Preview">
                        </a>
                    </div>
                    <div class="news-sideabr__content-box">
                        <ul class="list-unstyled news-sideabr__meta">
                            <li>
                                <a href="#">
                                    <i class="far fa-calendar"></i>
                                    {{$post->published_at}}
                                </a>
                            </li>
                        </ul>
                        <h3 class="news-sideabr__title">
                            <a href="{{route('client.news.show', ['post' => $post->slug])}}">
                                {{$post->short_title}}
                            </a>
                        </h3>
                        <p class="news-sideabr__text">{!! $post->short_content !!}</p>
                        <div class="news-sideabr__bottom-btn-box">
                            <a href="{{route('client.news.show', ['post' => $post->slug])}}"
                               class="news-sideabr__btn thm-btn">{{__('news.readMore')}}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
