@extends('master')

@section('css')

@endsection
@section('js')
    @include('ckfinder::setup')
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="col-md-12">
                    <!-- general form elements -->

                    @include('layouts.errors')

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thêm quận/huyện</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {!! Form::open(array('method'=>'POST')) !!}
                        <div class="card-body row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code">Tên quận/huyện:</label>
                                    <input required name="name" type="text" class="form-control" id="code" placeholder="Ví dụ: Hoàng Mai" value="{{ old('name') }}" >
                                </div>
                                <div class="form-group">
                                    <label for="acc_num">Tỉnh/Thành phố:</label>
                                    <select class="form-control" name="city_code" id="" required>
                                        @foreach ($cities as $city)
                                            <option value="{{$city->code}}">{{$city->name_city}}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="code">Type(có thể để chống):</label>
                                    <input name="type" type="text" class="form-control" id="code" placeholder="Type" value="{{ old('type') }}" >
                                </div>



                                <div class="form-group">
                                    <label for="branch">Sắp xếp(có thể để trống):</label>
                                    <input name="sort" type="number" class="form-control" id="branch" placeholder="Sắp xếp" value="{{ old('sort') }}" >
                                </div>

                                <div class="form-group">
                                    <label for="withdraw">Nổi bật:</label>
                                    <select class="form-control" name="featured" id="">
                                        <option value="0">Không nổi bật</option>
                                        <option value="1">Nổi bật</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="withdraw">Trạng thái:</label>
                                    <select class="form-control" name="status" id="">
                                        <option value="0">Bật</option>
                                        <option value="1">Tắt</option>
                                    </select>
                                </div>

                            </div>



                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Thêm tỉnh/thành phố</button>
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
