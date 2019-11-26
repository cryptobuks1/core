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
                        {!! Form::model($user, ['method' => 'PATCH','route' => ['upgrade.update', $user->id]]) !!}

                                @hasrole('SUPER_ADMIN|ADMIN')
                                <div class="form-group ">
                                    <label for="roles">Quyền (khách hàng luôn là USER): </label>
                                    {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control select2','multiple')) !!}
                                </div>
                                @else

                                @endhasrole




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

