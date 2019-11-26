<footer class="footer dark" @if(isset($settings['footer_bg']) && $settings['footer_bg'] != '') style="background: {{ $settings['footer_bg'] }}" @endif>
    <div class="footer-main">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div><a class="title"><img src="{{url($settings['backendlogo'])}}"
                                               alt="{{ $settings['title'] }}"
                                               style="max-width: 221px;"/></a></div>
                    <br/>
                    <div>
                        <h5>{{ $settings['name'] }}</h5>
                        <p>{{ $settings['description'] }}</p>
                    </div>
                </div>
                <div class="col-sm-9">
                        <div class="row">
                            @theme_include('widgets.footer-menu')
                            <div class="col-sm-4 col-xs-6">
                                <div>
                                    <h3 class="title divider-bottom">Cộng đồng</h3>
                                </div>
                                <div>
                                    <p>Liên kết mạng xã hội:</p>
                                    <div class="social-icon"><a href="{{ url($settings['facebook']) }}"><i class="fab fa-facebook-f"></i></a>
                                    </div>
                                    <div class="social-icon"><a href="{{ url($settings['googleplus']) }}"><i class="fab fa-google-plus-g"></i></a>
                                    </div>
                                    <div class="social-icon"><a href="{{ url($settings['twitter']) }}"><i class="fab fa-twitter"></i></a>
                                    </div>
                                    <div class="social-icon"><a href="{{ url($settings['youtube']) }}"><i class="fab fa-youtube"></i></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">{{ $settings['copyright'] }}
            @if(count($languages) > 1)
            <div class="pull-right">
                     @foreach($languages as $keylang => $lang)
                        <a href="{{url('/change-lang?code=').$keylang}}" style="color: #8b8b8b"> <span style="margin-left: 10px; @if(cache()->get('language') == $keylang) color: #f0fafb; @endif">{{$lang}}</span></a>
                    @endforeach
            </div>
                @endif
        </div>

    </div>
</footer>