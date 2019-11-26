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

                            {!! Form::model($type, ['method' => 'PATCH','route' => ['type.update', $type->id]]) !!}

                            <div class="card-body row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="form_id">Hình thức:</label>
                                            <select name="form_id" id="" class="form-control">
                                                <option value="0" @if($type->form_id==0) selected @endif>Nhà đất bán</option>
                                                <option value="1" @if($type->form_id==1) selected @endif>Nhà đất cho thuê</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">Tên phân loại:</label>
                                            <input name="name" type="text" class="form-control" id="title" placeholder="Type Name" value="{{$type->name or old('name')}}" >
                                        </div>
                                        <div class="" style="padding-top: 20px">
                                            <div class="form-group">
                                                <label for="status">Trạng thái</label>
                                                <input name="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" @if( $type->status == 1 ) checked="checked" @endif>
                                                <div class="Switch Round @if($type->status == 1) Off @else On @endif" style="vertical-align:top;margin-left:10px;">
                                                    <div class="Toggle"></div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{route('type.index')}}" class="btn btn-danger">Hủy</a>
                                    </div>
                            </div>
                            @csrf
                            {!! Form::close() !!}

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
