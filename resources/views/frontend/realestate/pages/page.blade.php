@extends('frontend.'.$current_theme.'.common')
@section('title', $page->title)
@section('customstyle')

@endsection

@section('breadcrumbs', Breadcrumbs::render('page',$page))

@section('content')
    <div class="blockPage">
        <div class="blockTitle">
            <h1>{{ $page->title }}</h1>
        </div>
        <div class="blockContent">
                   <div class="detail">
                    {!! $page->description !!}
                </div>

        </div>
    </div>
@endsection


@section('js-footer')
@endsection