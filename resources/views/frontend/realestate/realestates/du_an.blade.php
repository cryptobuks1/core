@extends('frontend.'.$current_theme.'.app')
@section('title')
@section('customstyle')

@section('customstyle')
    <link rel="stylesheet" href="{{asset('assets/default/css/fontawesome-stars.css')}}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/font-awesome/css/font-awesome.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <style>
        #menu{
            background: #fbfbfb;
            border: 1px solid #ddd;
            padding-left: 0;
        }
        #menu-item {
            list-style: none;
            height: 40px;
            line-height: 40px;
            border-bottom: 1px solid #ddd;
            padding-left: 15px;
            text-decoration: none;
        }
        .menu-item a, a:hover {
            color: black;
            text-decoration: none;
        }
        #menu-item a:first-child{
            background: #f5f5f5;
            text-transform: uppercase;
        }
        li{
            list-style: none;
        }
        figure.effect-ming {
            background: #030c17;
        }
        figure.effect-ming img {
            opacity: 0.9;
            -webkit-transition: opacity 0.35s;
            transition: opacity 0.35s;
        }
        figure.effect-ming figcaption::before {
            position: absolute;
            top: 30px;
            right: 30px;
            bottom: 30px;
            left: 30px;
            border: 2px solid #fff;
            box-shadow: 0 0 0 30px rgba(255,255,255,0.2);
            content: '';
            opacity: 0;
            -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
            transition: opacity 0.35s, transform 0.35s;
            -webkit-transform: scale3d(1.4,1.4,1);
            transform: scale3d(1.4,1.4,1);
        }
        figure.effect-ming h2 {
            margin: 20% 0 10px 0;
            -webkit-transition: -webkit-transform 0.35s;
            transition: transform 0.35s;
        }
        figure.effect-ming p {
            padding: 1em;
            opacity: 0;
            -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
            transition: opacity 0.35s, transform 0.35s;
            -webkit-transform: scale(1.5);
            transform: scale(1.5);
        }
        figure.effect-ming:hover h2 {
            -webkit-transform: scale(0.9);
            transform: scale(0.9);
        }
        figure.effect-ming:hover figcaption::before,
        figure.effect-ming:hover p {
            opacity: 1;
            -webkit-transform: scale3d(1,1,1);
            transform: scale3d(1,1,1);
        }
        figure.effect-ming:hover figcaption {
            background-color: rgba(58,52,42,0);
        }
        figure.effect-ming:hover img {
            opacity: 0.4;
        }
        .grid {
            position: relative;
            clear: both;
            margin: 0 auto;
            padding: 1em 0 4em;
            max-width: 1000px;
            list-style: none;
            text-align: center;
        }
        /* Common style */
        .grid figure {
            position: relative;
            float: left;
            overflow: hidden;
            margin: 10px 1%;
            min-width: 320px;
            max-width: 480px;
            max-height: 360px;
            width: 48%;
            height: auto;
            background: #3085a3;
            text-align: center;
            cursor: pointer;
        }
        .grid figure img {
            position: relative;
            display: block;
            min-height: 100%;
            max-width: 100%;
            opacity: 0.8;
        }
        .grid figure figcaption {
            padding: 2em;
            color: #fff;
            text-transform: uppercase;
            font-size: 1.25em;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }
        .grid figure figcaption::before,
        .grid figure figcaption::after {
            pointer-events: none;
        }
        .grid figure figcaption,
        .grid figure figcaption > a {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        /* Anchor will cover the whole item by default */
        /* For some effects it will show as a button */
        .grid figure figcaption > a {
            z-index: 1000;
            text-indent: 200%;
            white-space: nowrap;
            font-size: 0;
            opacity: 0;
        }
        .grid figure h2 {
            word-spacing: -0.15em;
            font-weight: 300;
        }
        .grid figure h2 span {
            font-weight: 800;
        }
        .grid figure h2,
        .grid figure p {
            margin: 0;
        }
        .grid figure p {
            letter-spacing: 1px;
            font-size: 68.5%;
        }
        figure.effect-winston {
            background: #162633;
            text-align: left;
        }
        figure.effect-winston img {
            -webkit-transition: opacity 0.45s;
            transition: opacity 0.45s;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }
        figure.effect-winston figcaption::before {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: 100% 100%;
            content: '';
            -webkit-transition: opacity 0.45s, -webkit-transform 0.45s;
            transition: opacity 0.45s, transform 0.45s;
            -webkit-transform: rotate3d(0,0,1,45deg);
            transform: rotate3d(0,0,1,45deg);
            -webkit-transform-origin: 0 100%;
            transform-origin: 0 100%;
        }
        figure.effect-winston h2 {
            -webkit-transition: -webkit-transform 0.35s;
            transition: transform 0.35s;
            -webkit-transform: translate3d(0,20px,0);
            transform: translate3d(0,20px,0);
        }
        figure.effect-winston p {
            position: absolute;
            right: 0;
            bottom: 0;
            padding: 0 1.5em 7% 0;
        }
        figure.effect-winston a {
            margin: 0 10px;
            color: #5d504f;
            font-size: 170%;
        }
        figure.effect-winston a:hover,
        figure.effect-winston a:focus {
            color: #cc6055;
        }
        figure.effect-winston p a i {
            opacity: 0;
            -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
            transition: opacity 0.35s, transform 0.35s;
            -webkit-transform: translate3d(0,50px,0);
            transform: translate3d(0,50px,0);
        }
        figure.effect-winston:hover img {
            opacity: 0.6;
        }
        figure.effect-winston:hover h2 {
            -webkit-transform: translate3d(0,0,0);
            transform: translate3d(0,0,0);
        }
        figure.effect-winston:hover figcaption::before {
            opacity: 0.7;
            -webkit-transform: rotate3d(0,0,1,20deg);
            transform: rotate3d(0,0,1,20deg);
        }
        figure.effect-winston:hover p i {
            opacity: 1;
            -webkit-transform: translate3d(0,0,0);
            transform: translate3d(0,0,0);
        }
        figure.effect-winston:hover p a:nth-child(3) i {
            -webkit-transition-delay: 0.05s;
            transition-delay: 0.05s;
        }
        figure.effect-winston:hover p a:nth-child(2) i {
            -webkit-transition-delay: 0.1s;
            transition-delay: 0.1s;
        }
        figure.effect-winston:hover p a:first-child i {
            -webkit-transition-delay: 0.15s;
            transition-delay: 0.15s;
        }
    </style>
@endsection

@section('content')
    <section class="content">
        @include('frontend.default.realestates.menu')
        <div class="tren">
            <h1 style="text-align: center">DỰ ÁN</h1>
        </div>
        <div class="du-an">
            @include('frontend.default.realestates.menu_project')
            @if(count($project)>0)
                <div class="col-md-9">
                    <div class="project-item" >
                        <div class="row">
                            @foreach($project as $item)
                                <div class="col-md-6 col-sm-6 col-xs-12"  >
                                    <div class="grid" >
                                        <figure class="effect-ming">
                                            <img src="@if($item->image){{ url($item->image) }}@endif" alt="img09" style="height: 250px"/>
                                            <figcaption>
                                                <h3>{{$item->name}}</h3>
                                                <p>Địa chỉ: {{$item->address}}</p>
                                                <a href="{{asset(asset('realestates/du-an/'.$item->slug.'/'.$item->id))}}">View more</a>
                                            </figcaption>
                                        </figure>
                                    </div>
                                    <div>

                                    </div>
                                    <div  class="col-md-12 col-sm-12 col-xs-12" >
                                        <h4><a href="{{asset(asset('realestates/du-an/'.$item->slug.'/'.$item->id))}}">{{$item->name}}</a></h4>
                                        <p><label for="">Chủ đầu tư:</label> <span style="font-weight: 600;color: green"> {{$item->investor}}</span></p>
                                        <p><label for="">Tiến trình:</label><span>@if($item->process) {{$item->process}} @else Đang cập nhật @endif </span></p>
                                        <hr>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{$project->links()}}
                </div>
            @else
                Không có dự án nào.
            @endif
        </div>
    </section>
    <!-- Main content -->

@endsection

@section('js-footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script >
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $("#cities").on('change', (function(e){
                var city_code = $(this).val();
                $.ajax({
                    type:'POST',
                    url:'{{ route('ajax.project') }}',
                    data:{code:city_code},
                    success:function(data){
                        $('#provinces').html(data);
                    }
                });
            }));
        });
    </script>
@endsection
