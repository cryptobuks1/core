@extends('frontend.'.$current_theme.'.app')
@section('breadcrumbs', Breadcrumbs::render('default','Đăng ký'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Đăng ký') }}</h4>
                </div>
                @theme_include('errors.errors')
                <div class="card-body">
                    <form method="POST" action="{{ route('frontend.account.store') }}" aria-label="{{ __('Đăng ký') }}">
                        @csrf

                        @if($settings['require_username'] && $settings['require_username'] == 1)

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Tên đăng nhập') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus placeholder="Tên đăng nhập">
                            </div>
                        </div>

                        @endif
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Họ tên') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Họ tên">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phoneOrEmail" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail/Số điện thoại') }}</label>

                            <div class="col-md-6">
                                <input id="phoneOrEmail" type="text" class="form-control" name="phoneOrEmail" value="{{ old('phoneOrEmail') }}" placeholder="E-Mail/Số điện thoại" required>
                                <input type="hidden" class="form-control" name="ref" value="@if($ref){{$ref}}@endif" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mật khẩu') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required placeholder="Mật khẩu">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mã xác nhận') }}</label>

                            <div class="col-md-6">
                                <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                                <script src='https://www.google.com/recaptcha/api.js'></script>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Đăng ký') }}
                                </button>
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
