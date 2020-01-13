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
                <h3 class="card-title">Thêm loại TOUR</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::open(array('route' => 'tour.type.store','method'=>'POST')) !!}
                <div class="card-body row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="type">Loại TOUR:</label>
                                <select name="type"  class="form-control">
                                    <option value="domestic">Trong nước</option>
                                    <option value="foreign">Ngoài nước</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Tên:</label>
                                <input name="name" type="text" required class="form-control" id="code" placeholder="Nhập tên" value="{{ old('name') }}" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status">Trạng thái:</label>
                                <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" checked="checked">
                                <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                                    <div class="Toggle"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                    <div class="col-md-12">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Thêm</button>
                            <a href="{{route('tour.type.index')}}" class="btn btn-warning">Đóng</a>
                        </div>
                    </div>
                    @csrf
                {!! Form::close() !!}
            </div>
            <!-- /.card -->
              </div>
              <!-- /.card-body -->
            </div>
    <!-- /.card -->

    </div>
    <!-- /.card -->

</section>
<!-- /.content -->
@endsection
