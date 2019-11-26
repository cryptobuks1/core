@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker-bs3.css') }}">

@endsection
@section('js')
@endsection

@section('content')
    <style>
         table td{
            font-size: 15px;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="col-md-12">
                    <!-- general form elements -->
                    @include('layouts.errors')
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Sửa phân loại</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                            {!! Form::model($data, ['method' => 'PATCH','route' => ['group.update', $data->id]]) !!}

                            <div class="card-body row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="form_id">Tên Vip:</label>
                                            <input type="text" name="name" class="form-control" placeholder="Nhập tên nhóm dự án" value="{{$data->name or old('name')}}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">Code:</label>
                                            <input name="code" type="text" class="form-control" id="code" placeholder="Nhập code" value="{{$data->code or old('code')}}" >
                                        </div>

                                        <div class="col-md-6">
                                            <label for="status">Trạng thái:</label>
                                            <select class="form-control" name="status" id="status" >
                                                <option value="1" @if($data['status'] == 1) selected="selected" @endif>Bật</option>
                                                <option value="0" @if($data['status'] == 0) selected="selected" @endif>Tắt</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{route('vip.index')}}" class="btn btn-danger">Hủy</a>
                                    </div>
                            </div>
                            @csrf
                            {!! Form::close() !!}
{{--                        </form>--}}
{{--                        {!! Form::close() !!}--}}
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
