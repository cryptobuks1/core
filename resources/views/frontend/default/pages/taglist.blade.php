@extends('frontend.'.$current_theme.'.common')

@section('content')

    <div class="blockContent">
        <h1 class="panel-title">{{$code}}</h1>

        @if(count($tags))
            @foreach($tags as $item)
                <div class="blogItem normalCat">
                    <a class="cover" href="{{ $item->info['url'] }}">
                        <img src="{{ $item->info['image'] }}" width="100px" height="80px" alt="{{ $item->info['title'] }}">
                    </a>
                    <div class="detail">
                        <a class="title" href="{{ $item->info['url'] }}">{{ $item->info['title'] }}</a>
                        <p>{{ $item->info['desc'] }}</p>
                        <a href="{{ $item->info['url'] }}" class="btn btn-viewmore">Xem chi tiết</a>
                    </div>
                </div><br>
            @endforeach
            {{ $tags->links() }}
        @endif
    </div>


@endsection

@section('extra-js')
@endsection



