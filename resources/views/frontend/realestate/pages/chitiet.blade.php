@extends('frontend.'.$current_theme.'.common')
@section('title', $news->title)
@section('customstyle')

@endsection

@section('breadcrumbs', Breadcrumbs::render('chi-tiet',$news))

@section('content')
    <div class="blockPage">
      <div class="blockTitle">
        <h1>{{ $news->title }}</h1>
        <div class="info-meta">
			<div class="info-inline"><i class="fa fa-clock-o"></i>{{ $news->created_at->format('H:i') }}</div>
			<div class="info-inline">
				<div class="fa fa-calendar-o"></div> {{ $news->created_at->format('d/m/Y') }}
			</div>
			<div class="info-inline">
				<div class="fa fa-eye"></div>  {{ $news->view_count }}
			</div>
        </div>
        <hr>
        <h2>{{ $news->short_description }}</h2>
      </div>
      <div class="blockContent">
        <div class="blogItem detailContent">
			<div class="detail">
				{!! $news->content !!}
			</div>
        </div>
      </div>
    </div>
    <div>
		<div class="blockTitle">
			<h3><span><i class="fa fa-tags"></i> Tags</span></h3>
		</div>
		<div class="blockContent">
			@if(count($tags))
				@foreach($tags as $tag)
					<a class="tag-item" href="{{ url('tags').'/'.$tag->code }}">{{ $tag->label }}</a>
				@endforeach
			@endif
		</div>
    </div>
@endsection


@section('js-footer')
@endsection