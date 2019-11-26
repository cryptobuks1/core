@if(isset($settings['google_analytic_id']) && $settings['google_analytic_id'] !=="N/A")
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{$settings['google_analytic_id']}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{$settings['google_analytic_id']}}');
    </script>
@endif

@if(isset($settings['footer_js']) && $settings['footer_js'] !== "N/A")

    {!! $settings['footer_js'] !!}

@endif

<script src="{{ theme_asset('libs/jquery/jquery.min.js') }}"></script>
<script src="{{ theme_asset('libs/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ theme_asset('libs/OwlCarousel2/owl.carousel.min.js') }}"></script>
<script src="{{ theme_asset('js/main.min.js') }}"></script>
