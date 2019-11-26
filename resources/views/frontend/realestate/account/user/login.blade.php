@extends('frontend.'.$current_theme.'.app')

@section('breadcrumbs', Breadcrumbs::render('default','Đăng nhập'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @theme_include('errors.errors')
                <div class="card-header">
                    <h4>{{getlang('auth.titlelogin')}}</h4>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('frontend.account.login') }}" aria-label="{{ __('profiles.login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{getlang('auth.username')}}</label>

                            <div class="col-md-6">
                                <input id="phoneOrEmail" type="text" class="form-control" name="phoneOrEmail" value="{{ old('phoneOrEmail') }}" required autofocus placeholder="{{getlang('auth.loginaccount')}}">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{getlang('auth.password')}}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required placeholder="{{getlang('auth.password')}}">

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{getlang('auth.remember')}}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{getlang('auth.buttonlogin')}}
                                </button>

                                <a class="btn btn-link" href="{{ route('user.password.email') }}">
                                    {{getlang('auth.forgotpassword')}}
                                </a>
                            </div>
                        </div>
                    </form>
                    <br>
                    @if($settings['social_login'] == 1)
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <a href="{{url('auth/facebook')}}" class="btn btn-lg btn-primary btn-block">Facebook</a>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <a href="#" class="btn btn-lg btn-danger btn-block">Google</a>
                        </div>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
