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
                            <h3 class="card-title">Thêm quận huyện</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {!! Form::open(array('method'=>'POST')) !!}
                        <div class="card-body row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code">Tên tỉnh/thành phố:</label>
                                    <input required name="name_city" type="text" class="form-control" id="code" placeholder="Ví dụ: Hà Nội" value="{{ old('name_city') }}" >
                                </div>
                                <div class="form-group">
                                    <label for="name">Tên viết tắt:</label>
                                    <input required name="code" type="text" class="form-control" id="name" placeholder="Tên viết tắt" value="{{ old('code') }}" >
                                </div>
                                <div class="form-group">
                                    <label for="acc_num">Quốc gia:</label>
                                    <select class="form-control" name="country_code" id="" required>
                                        @foreach ($countries as $coun)
                                            <option value="{{$coun->code}}">{{$coun->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="card_num">Vùng miền(có thể để trống):</label>
                                    <select class="form-control" name="region" id="" >
                                        <option value="">Chọn vùng</option>
                                        <option value="Miền Bắc">Miền Bắc</option>
                                        <option value="Miền Trung">Miền Trung</option>
                                        <option value="Miền Nam">Miền Nam</option>
                                    </select>
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
