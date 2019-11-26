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
                <h3 class="card-title">Thêm mới</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::open(array('route' => 'admin.blocks.content.create','method'=>'POST')) !!}
                <div class="card-body row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="title">Tên nội dung:</label>
                      <input name="title" type="text" class="form-control" id="title" placeholder="Tên nội dung" value="{{ old('title') }}" >
                    </div>
                    <div class="form-group">
                      <label for="icon">Icon:</label>
                      <input name="icon" type="text" class="form-control" id="icon" placeholder="Mã fa icon, ví dụ: fa-plus" value="{{ old('icon') }}" >
                    </div>
                    <div class="form-group row">
                      <label for="url">Ảnh:</label>
                       <img id="logo-icon" class="imgPreview" src="{{ old('image') }}"/>
                        <input type="hidden" name="image" id="image" class="inputImg" value=""/>

                      <div style="margin-left: 15px">
                        <button type="button" class="btn btn-warning"
                                onclick="selectFileWithCKFinder('image', 'logo-icon')">Chọn ảnh
                        </button>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="info">Mô tả ngắn:</label>
                      <input name="info" type="text" class="form-control" id="info" placeholder="Tối đa 255 ký tự" value="{{ old('info') }}" >
                    </div>
                    <div class="form-group">
                      {!! $content !!}
                    </div>
                    <div class="form-group">
                      <label for="url">Đường dẫn:</label>
                      <input name="url" type="text" class="form-control" id="url" placeholder="https://" value="{{ old('url') }}" >
                    </div>
                       <div class="form-group">
                      <label for="status">Trạng thái:</label>
                      <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" checked="checked">
                      <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                        <div class="Toggle"></div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="name">Thứ tự:</label>
                      <input name="sort" type="number" class="form-control" id="sort" value="0">
                    </div>

                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input name="lang" type="hidden" value="{{ $block->lang }}" >
                  <input name="block" type="hidden" value="{{ $block->id }}" >
                  <button type="submit" class="btn btn-primary">Thêm nội dung</button>
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