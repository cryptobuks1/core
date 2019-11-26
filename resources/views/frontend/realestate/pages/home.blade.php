@extends('frontend.'.$current_theme.'.master')
@section('title', $settings['title'])
@section('description', $settings['description'])
@section('meta-tags')
    {!! $seo_advanced !!}
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('customstyle')
    <link rel="stylesheet" href="{{ theme_asset('css/softcard.css') }}" type="text/css">
    <style>
        .tab .nav-tab li.active a {
            background-color: @if(isset($settings['top_bg']) && $settings['top_bg'] != null) {{$settings['top_bg']}} @endif;
            transition: 1s all;
             border: @if(isset($settings['footer_bg']) && $settings['footer_bg'] != null) {{$settings['footer_bg']}} @endif;
        }

        .tab .nav-tab li a:after {
            transition: 1s all;
            background-color: @if(isset($settings['footer_bg']) && $settings['footer_bg'] != null) {{$settings['footer_bg']}} @endif;
        }
    </style>
@endsection

@section('content')

    @theme_include('widgets.'.$settings['type_slider'])

    <section class="main">

        <div class="section">
            <div class="container">
                <div class="fullColumn">
                    <br>
                    <div class="blockContent">
                        @theme_include('errors.errors')

						Write something here!!
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@section('js-footer')

    @if($settings['globalpopup'] == 1)
        <script>
            $(document).ready(function () {
                $('#global-modal').modal('show');
            });
        </script>


        <div id="global-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Thông báo</h4>
                    </div>
                    <div class="modal-body">
                        <p>{!! $settings['globalpopup_mes'] !!}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    </div>
                </div>

            </div>
        </div>
    @endif


@endsection
