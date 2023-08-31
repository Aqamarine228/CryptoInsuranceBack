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
        <div class="sidebar__single sidebar__category">
            <h3 class="sidebar__title">{{__('news.categories')}}</h3>
            <ul class="sidebar__category-list list-unstyled">
                @foreach($categories as $category)
                    <li><a href="{{route('client.news.category', $category->slug)}}">{{$category->name}}<span
                                class="fas fa-angle-double-right"></span></a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="sidebar__single sidebar__tags">
            <h3 class="sidebar__title">{{__('news.mostPopularTags')}}</h3>
            <div class="sidebar__tags-list">
                @foreach($tags as $tag)
                    <a href="{{route('client.news.tag', $tag->slug)}}">{{$tag->name}}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
