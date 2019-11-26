@extends('frontend.'.$current_theme.'.common')
@section('customstyle')
@endsection

@section('content')
    <div class="blockPage">
      <div class="blockTitle">
          @theme_include('errors.errors')
          <h1><span class="text-uppercase">Mã quà tặng</span></h1>
          {!! $gcform !!}

    </div>
    </div>

@endsection
@section('js-footer')
@endsection