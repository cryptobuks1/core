@extends('frontend.'.$current_theme.'.common')
@section('breadcrumbs', Breadcrumbs::render('userpanel'))
@section('content')
    <h4><span class="text-uppercase">Sửa thông tin tài khoản</span></h4>
    @theme_include('errors.errors')
    <div class="blockContent">
        <div class="row">
            <div class=" col-md-12">
                {!! Form::open(array('route' => 'edit.profile','method'=>'POST')) !!}
                    <table class="table">
                        <tbody>

                        @if(!$info->username)
                        <tr>
                            <td>Tên đăng nhập:</td>
                            <td><input type="text" class="form-control" name="username"
                                       value="{{$info->username}}"></td>
                        </tr>
                        @endif

                        <tr>
                            <td>Họ và tên:</td>
                            <td><input type="text" class="form-control" name="name"
                                       value="{{$info->name}}"></td>
                        </tr>
                        @if(!$info->email)
                        <tr>
                            <td>Email:</td>
                            <td><input type="text" class="form-control" name="email"
                                       value="{{$info->email}}"></td>
                        </tr>
                        @endif

                        @if(!$info->phone)
                        <tr>
                            <td>Số điện thoại:</td>
                            <td><input type="text" class="form-control" name="phone"
                                       value="{{$info->phone}}"></td>
                        </tr>
                        @endif
                        <tr>
                            <td>Giới tính:</td>
                            <td>
                                <select name="gender" class="form-control" style="padding: 2px">
                                    <option value=""></option>
                                    <option value="male" @if($info->gender == 'male') selected="selected" @endif >Nam</option>
                                    <option value="female" @if($info->gender == 'female') selected="selected" @endif >Nữ</option>
                                </select>
                            </td>
                        </tr>
                        @if(!$info->mkc2)
                        <tr>
                            <td>Mật khẩu cấp 2:</td>
                            <td><input type="password" class="form-control" name="mkc2"
                                       value="{{$info->name}}">

                            </td>
                        </tr>
                        @endif

                        </tbody>
                    </table>

                    <input type="submit" class="btn btn-success" value="Cập nhật thông tin">
                {!! Form::close() !!}

            </div>



        </div>
    </div>

@endsection
