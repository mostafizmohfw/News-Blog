<div class="main-banner header-text">
    <div class="container-fluid">
        <div class="owl-banner owl-carousel">
            @foreach($slider_posts as $slider_post)
                <div class="item">
                    <img src="{{$slider_post->photo}}" alt="">
                    <div class="item-content">
                        <div class="main-content">
                            <div class="meta-category">
                                <span>{{$slider_post->category?->name}}</span>
                            </div>
                            <a href="{{route('front.single', $slider_post->slug)}}"><h4>{{$slider_post->title}}</h4></a>
                            <ul class="post-info">
                                <li><a href="#">{{$slider_post->user?->name}}</a></li>
                                <li><a href="javascript:void">{{ $slider_post->created_at->format('M d, Y')}}</a></li>
                                <li><a href="{{route('front.single', $slider_post->slug)}}#formComment">{{$slider_post->comment?->count()}} Comments</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
