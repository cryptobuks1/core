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

                            {!! Form::model($vip, ['method' => 'PATCH','route' => ['vip.update', $vip->id]]) !!}

                            <div class="card-body row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="form_id">Tên Vip:</label>
                                            <input type="text" name="name" class="form-control" value="{{$vip->name or old('name')}}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">Giá/Ngày:</label>
                                            <input name="price" type="text" class="form-control" id="price" placeholder="Nhập giá/ngày" value="{{$vip->price or old('price')}}" >
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">Số Ngày:</label>
                                            <input name="day" type="number" required class="form-control" id="day" placeholder="Nhập số ngày" value="{{$vip->day or old('day')}}" >
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">Level:</label>
                                            <input name="level" type="number" required class="form-control" id="level" placeholder="Nhập Level" value="{{$vip->level or old('level')}}" >
                                        </div>
                                        <div class="col-md-6">
                                            <label for="status">Trạng thái:</label>
                                            <select class="form-control" name="status" id="status" >
                                                <option value="1" @if($vip['status'] == 1) selected="selected" @endif>Bật</option>
                                                <option value="0" @if($vip['status'] == 0) selected="selected" @endif>Tắt</option>
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
