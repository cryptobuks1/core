@extends('frontend.'.$current_theme.'.common')

@section('customstyle')
@endsection

@section('breadcrumbs', Breadcrumbs::render('default','Đổi mật khẩu'))

@section('content')
    <div class="change-password-page">
        <h4><span class="text-uppercase">Đổi mật khẩu</span></h4>

        @theme_include('errors.errors')

        {!! Form::open(array('route' => 'frontend.account.changepassword','method'=>'POST','name'=>'change-password')) !!}
            <div class="form-group">
                <label for="old-pwd">Mật khẩu hiện tại:</label>
                <input id="old-pwd" type="password" class="form-control" name="old-pwd" required="" placeholder="Mật khẩu cũ">
            </div>
            <div class="form-group">
                <label for="new-pwd">Mật khẩu mới:</label>
                <input id="new-pwd" type="password" class="form-control" name="new-pwd" required="" placeholder="Mật khẩu mới">
            </div>
            <div class="form-group">
                <label for="new-pwd-confirmation">Xác nhận mật khẩu:</label>
                <input id="new-pwd-confirmation" type="password" class="form-control" name="new-pwd-confirmation" required="" placeholder="Xác nhận mật khẩu">
            </div>
            <button type="submit" class="btn btn-primary">Xác nhận</button>
        {!! Form::close() !!}
    </div>
@endsection
@section('js-footer')
@endsection
