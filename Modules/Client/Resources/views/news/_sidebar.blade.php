<div class="col-xl-4 col-lg-5">
    <div class="sidebar">
        <div class="sidebar__single sidebar__search">
            <form action="{{route('client.news.search')}}" class="sidebar__search-form">
                <input type="search" name="search" placeholder="{{__('news.search')}}" value="{{request()->get('search')}}">
                <button type="submit"><i class="icon-magnifying-glass"></i></button>
            </form>
        </div>
        <div class="sidebar__single sidebar__post">
            <h3 class="sidebar__title">{{__('news.latest')}}</h3>
            <ul class="sidebar__post-list list-unstyled">
                @foreach($latestPosts as $latestPost)
                    <li>
                        <div class="sidebar__post-image">
                            <img src="{{$latestPost->picture}}" alt="Post Picture">
                        </div>
                        <div class="sidebar__post-content">
                            <h3>
                                <a href="{{route('client.news.show', $latestPost->slug)}}">
                                    {{$latestPost->short_title}}
                                </a>
                            </h3>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
