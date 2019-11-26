@extends('frontend.'.$current_theme.'.app')
@section('breadcrumbs', Breadcrumbs::render('default','Khôi phục mật khẩu'))
@section('content')
<div class="container">
    <div class="row justify-content-center">

        @theme_include('errors.errors')

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Cập nhật mật khẩu mới') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.phone.post') }}">
                        @csrf

                        <input type="hidden" name="tmp_token" value="{{ $tmp_token }}">
                        <input type="hidden" name="phone" value="{{ $phone }}">

                        <div class="form-group row">
                            <label for="verify" class="col-md-4 col-form-label text-md-right">{{ __('Mã xác nhận SMS (kiểm tra tin nhắn):') }}</label>

                            <div class="col-md-6">
                                <input id="verify" type="verify" class="form-control{{ $errors->has('verify') ? ' is-invalid' : '' }}" name="verify" value="" required autofocus>

                                @if ($errors->has('verify'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('verify') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mật khẩu mới (tối thiểu 6 ký tự):') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Cập nhật mật khẩu') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
