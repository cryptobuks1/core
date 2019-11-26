@extends('frontend.'.$current_theme.'.common')

@section('title', 'Tin tức')

@section('breadcrumbs', Breadcrumbs::render('tin-tuc'))


@section('content')
<div class="blockContent">
	@if(count($news))
	@foreach($news as $post)
    	<div class="blogItem normalCat">
    		<a class="cover" href="{{ url('/tin-tuc').'/'.$post->news_slug }}">
    			<img src="{{ asset('/').$post->image }}" width="200" height="140" alt="{{ $post->title }}">
    		</a>
	      	<div class="detail">
	      		<a class="title" href="{{ url('/tin-tuc').'/'.$post->news_slug }}">{{ $post->title }}</a>
	        	<div class="info-meta">
	        		<span class="info-inline"><i class="fa fa-clock-o"></i>{{ $post->created_at->format('H:i') }}</span>
	        		<span class="info-inline"><i class="fa fa-calendar-o"></i>{{ $post->created_at->format('d/m/Y') }}</span>
	        	</div>
	        	<p>{{ $post->short_description }}</p>
	        	<a href="{{ url('/tin-tuc').'/'.$post->news_slug }}" class="btn btn-viewmore">Xem chi tiết</a>
	      	</div>
	    </div>
	@endforeach
    {{ $news->links() }}
    @endif
</div>
@endsection


@section('js-footer')
@endsection