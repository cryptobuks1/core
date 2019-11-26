@if( ! Auth::check() )
    <a href="{{ url('logo') }}" class="animated-arrow right-menu-toggle off-menu mobile-user-icon  ">
        <button type="button" class="btn btn-user btn-sm outline"><i class="fa fa-user"></i>Tài khoản</button>
    </a>
    <div class="rightVerticleMenu off-menu"
         @if(isset($settings['footer_bg']) && $settings['footer_bg'] != '') style="background: {{$settings['footer_bg']}}" @endif>
        <div class="brand-block"><a class="navbar-brand" href="{{url('/')}}"><img
                        src="{{ url($settings['backendlogo']) }}"
                        alt=""/></a></div>
        <div class="content-menu">
            <ul class="list-menu listMenuUserPanel">
                <li><a href="{{route('frontend.account.login')}}">Đăng nhập</a></li>
                <li><a href="{{route('frontend.account.register')}}">Đăng ký</a></li>
            </ul>
        </div>
    </div>
@else
    <a class="animated-arrow right-menu-toggle off-menu mobile-user-icon">
        <button type="button" class="btn btn-user btn-sm outline"><i class="fa fa-user"></i>{{Auth::user()->name}}</button>
    </a>
    <div class="rightVerticleMenu off-menu"
         @if(isset($settings['footer_bg']) && $settings['footer_bg'] != '') style="background: {{$settings['footer_bg']}}" @endif>
        <div class="brand-block"><a class="navbar-brand" href="{{url('/')}}"><img
                        src="{{ url($settings['backendlogo']) }}"
                        alt=""/></a></div>
        <div class="content-menu">
            <ul class="list-menu listMenuUserPanel">
                <li>
                  <h4 style="padding-left: 5px">Số dư: {{userinfo()->balance}}</h4>
                </li>
                @theme_include('account.userpanel')
            </ul>
        </div>
    </div>
@endif
<div class="top"  @if(isset($settings['top_color']) && $settings['top_color'] != '') style="background-color:{{$settings['top_bg']}} " @endif>
    <div class="container">
        <ul class="top-menu menu-top float-left"
            @if(isset($settings['top_color']) && $settings['top_color'] != '') style="color: {{$settings['top_color']}}" @endif>
            <li><span><strong> <i class="fa fa-phone"></i>&nbsp;</strong><a
                            href="#link"
                            @if(isset($settings['top_color']) && $settings['top_color'] != '') style="color: {{$settings['top_color']}}" @endif>{{ $settings['phone'] }}
                        &nbsp;</a></span>
            </li>
            <li class="p-0"><span class="separate"></span></li>
            <li><span><strong><i class="fa fa-envelope"></i>&nbsp;</strong><a href="#link"
                                                                              @if(isset($settings['top_color']) && $settings['top_color'] != '') style="color: {{$settings['top_color']}}" @endif>{{ $settings['email'] }}
                        &nbsp;</a></span>
            </li>
        </ul>
        <div class="pull-right hidden-sm hidden-xs">
            <div style="padding-top: 8px">
                @if(count($currencies) > 1)
                    @foreach($currencies as $currency_c)
                        <a href="{{url('change-currency?id=').$currency_c->id}}" style="color: #ffffff">@if(session()->get('currency')->code == $currency_c->code)<span style="padding-right: 8px"><strong>{{$currency_c->code}}</strong></span>@else <span style="padding-right: 8px; opacity: 0.7"> {{$currency_c->code}} @endif</span></a>
                    @endforeach
                    @endif
            </div>
        </div>
    </div>
</div>
<header class="header-top">
    <div class="container">
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ url($settings['logo']) }}" alt=""/>
            </a>
        </div>

        @if(env('LOGIN') === true)
            @if(Auth::check())
        @theme_include('widgets.header-menu')
            @endif
        @else
            @theme_include('widgets.header-menu')
        @endif

        @if( ! Auth::check() )
            <span class="pull-right user-header">
                    {{--<span class="separate">&nbsp;</span>--}}
                <a href="{{ url('register') }}" class="btn btn-third">
                        <i class="icon ion-android-person"></i> {{getlang('profiles.register')}}
                    </a>
                    <a href="{{ url('login') }}" class="btn btn-second" @if($settings['footer_bg'] != '') style="background: {{$settings['footer_bg']}};border-color: {{$settings['footer_bg']}};" @endif>
                        <i class="fa ion ion-android-unlock"></i> @lang('profiles.login')

                    </a>
                </span>
        @else
            <span class="pull-right loginBox"
                  @if(isset($settings['footer_bg']) && $settings['footer_bg'] != '') style="color: {{$settings['footer_bg']}}" @endif>
                <span class="navi-wrapper">
                        <div class="navigation">
                            <ul>
                        <li>
                          <i class="far fa-money-bill-alt"
                             aria-hidden="true"></i> {{userinfo()->balance}}

                            </li>
                                <li>
                                    <a href="{{ url('profile') }}"
                                       @if(isset($settings['footer_bg']) && $settings['footer_bg'] != '') style="color: {{$settings['footer_bg']}}" @endif><i
                                                class="fa fa-user"
                                                aria-hidden="true"></i> {{Auth::user()->name}}</a>
                                    <ul>
                                        @theme_include('account.userpanel')
                                    </ul>
                                </li>
                            </ul>
                        </div>
                </span>
            </span>
        @endif

    </div>
</header>