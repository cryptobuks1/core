@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
@endsection
@section('js')
    <script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="col-md-12">
                    <!-- general form elements -->

                    @include('layouts.errors')

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Sửa thành viên: {{ $user->name }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {!! Form::model($user, ['method' => 'PATCH','route' => ['admin.update', $user->id]]) !!}
                        <div class="card-body row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">Username:</label>
                                    <input name="username" type="text" class="form-control" id="username" value="{{ $user->username }}">
                                </div>
                                <div class="form-group">
                                    <label for="name">Họ và tên:</label>
                                    <input name="name" type="text" class="form-control" id="name" placeholder="Enter Full Name" value="{{ $user->name or old('name') }}">
                                </div>
                                <div class="form-group ">
                                    <label for="email">Email:</label>
                                    <input name="email" type="email" class="form-control" id="email" placeholder="Email" value="{{ $user->email}}" >
                                </div>
                                <div class="form-group">
                                    <label for="phone">Số điện thoại:</label>
                                    <input name="phone" type="text" class="form-control" id="phone" placeholder="Enter Number Phone" value="{{ $user->phone or old('phone') }}">
                                </div>
                                <div class="form-group">
                                    <label for="gender">Giới tính:</label>
                                    {!! Form::select('gender', array('male'=>'Male','female'=>'Female','unknown'=>'Unknown'),$user->gender, array('class' => 'form-control')) !!}
                                </div>



                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="group">Nhóm: </label>
                                    {!! Form::select('group', $lsGroup,$user->group, array('class' => 'form-control')) !!}
                                </div>
                                @hasrole('SUPER_ADMIN|BACKEND')
                                <div class="form-group ">
                                    <label for="roles">Quyền (khách hàng luôn là USER): </label>
                                    {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control select2','multiple')) !!}
                                </div>
                                @else

                                    @endhasrole


                                    <div class="form-group ">
                                        <label for="password">Mật khẩu: </label>
                                        <input name="password" type="password" class="form-control" id="password" placeholder="Password" value="">
                                    </div>
                                    <div class="form-group ">
                                        <label for="repassword">Nhập lại mật khẩu:</label>
                                        <input name="password_confirmation" type="password" class="form-control" id="repassword" placeholder="Password" value="">
                                    </div>

                                    <div class="form-group ">
                                        <label for="mkc2">Mật khẩu cấp 2:</label>
                                        <input name="mkc2" type="password" class="form-control" id="mkc2" placeholder="Nhập mật khẩu cấp 2">
                                    </div>

                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
