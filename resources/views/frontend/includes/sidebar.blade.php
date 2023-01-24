<div class="col-lg-4">
    <div class="sidebar">
        <div class="row">
            <div class="col-lg-12">
                <div class="sidebar-item sidebar-search" >
                    {!! Form::open(['method'=>'get', 'route'=>'front.search']) !!}
                    <div class="input-group">
                        {!! Form::search('search', null,['class'=>'form-control', 'placeholder'=>'type to search...']) !!}
                        {!! Form::button('<i class="fa-solid fa-magnifying-glass"></i>',['class'=>'btn btn-success input-group-text', 'type'=>'submit']) !!}
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
            <div class="col-lg-12">
                <div class="sidebar-item recent-posts">
                    <div class="sidebar-heading">
                        <h2>{{__('Recent Posts')}}</h2>
                    </div>
                    <div class="content">
                        <ul>
                            @foreach($recent_posts as $post)
                            <li>
                                <a href="{{route('front.single', $post->slug)}}">
                                    <h5>{{$post->title}}</h5>
                                    <span>{{$post->created_at->format('M d, Y')}}</span>
                                </a>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="sidebar-item categories">
                    <div class="sidebar-heading">
                        <h2>Categories</h2>
                    </div>
                    <div class="content">
                        <ul>
                            @foreach($categories as $category)
                            <li><a href="{{route('front.category', $category->slug)}}">- {{$category->name}}</a>
                                <ul class="sidebar-sub-category">
                                    @foreach($category->sub_categories as $sub_category)
                                        <li><a href="{{route('front.sub_category',[ $category->slug, $sub_category->slug])}}">- {{$sub_category->name}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="sidebar-item tags">
                    <div class="sidebar-heading">
                        <h2>Tag Clouds</h2>
                    </div>
                    <div class="content">
                        <ul>
                            @foreach($tags as $tag)
                            <li><a href="{{route('front.tag', $tag->slug)}}">{{$tag->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
