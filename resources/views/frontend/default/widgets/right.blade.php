<div class="sidebar">
    <div class="row">
        <h4><span style="margin-left: 15px"><i class="fa fa-video"></i> Video</span></h4>
    </div>
    <div class="block-content">
        <div class="row">
            <div class="col-sm-12">
                @php $youtube = explode('watch?v=', $settings['youtube']) @endphp
                <iframe width="100%"  src="https://www.youtube.com/embed/@if(count($youtube) > 1){{$youtube[1]}}@endif" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

            </div>
        </div>
    </div>
</div>

@if(isset($list_news) && count($list_news))

<div class="sidebar">
    <div class="row lineHorizontal">
        <h4><span style="margin-left: 15px"><i class="fa fa-newspaper"></i> Tin mới</span></h4>
    </div>

        <div class="content-side">
            @foreach($list_news as $post)

                <div class="row" style="margin-bottom: 10px">
                    <div class="col-sm-10">
                        <div><a href="{{ url('tin-tuc').'/'.$post->news_slug }}"><strong>{{ $post->title }}</strong></a></div>
                        <small class="text-muted">{{ $post->updated_at }}</small>
                    </div>
                    <div class="col-sm-2">
                        <a href="{{ url('tin-tuc').'/'.$post->url_key }}" class="pull-right"><img width="50px" src="{{ asset($post->image) }}" class="img-circle"></a>
                    </div>
                </div>
            @endforeach
        </div>

</div>
@endif

