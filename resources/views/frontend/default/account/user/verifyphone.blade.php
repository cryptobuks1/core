@extends('frontend.'.$current_theme.'.app')
@section('breadcrumbs', Breadcrumbs::render('verifyphone'))
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @theme_include('errors.errors')
                <div class="card-header">
                    <h4>{{ __('Xác thực số điện thoại') }}</h4>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('frontend.account.verifyphone') }}">
                        @csrf
                        <label>Chúng tôi vừa gửi mã xác thực vào số điện thoại của bạn</label>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="veriphone" required autofocus placeholder="Nhập mã xác thực">
                                <input type="hidden" class="form-control" name="tmp_token" value="{{$tmp_token}}">
                                <input type="hidden" class="form-control" name="user_id" value="{{$user_id}}">

                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Xác thực ngay
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
