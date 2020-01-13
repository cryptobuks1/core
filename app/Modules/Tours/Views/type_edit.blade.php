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
                {!! Form::model($type, ['method' => 'PATCH','route' => ['tour.type.update', $type->id]]) !!}
                <div class="card-body row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="type">Loại TOUR:</label>
                                <select name="type"  class="form-control">
                                    <option value="domestic" @if($type->type == 'domestic') selected @endif >Trong nước</option>
                                    <option value="foreign" @if($type->type == 'foreign') selected @endif >Ngoài nước</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Tên:</label>
                                <input name="name" type="text" required class="form-control" id="code" placeholder="Nhập tên" value="{{ $type->name or old('name') }}" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status">Trạng thái:</label>
                                <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" @if($type->status == 1) checked="checked" @endif>
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
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
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
