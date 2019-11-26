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
      @include('layouts.errors')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Sửa: {{ $slider->slider_name }}</h3>
        </div>

        <!-- form start -->
        {!! Form::model($slider, ['method' => 'PATCH','route' => ['sliders.update', $slider->id],'enctype'=>'multipart/form-data']) !!}
        <div class="card-body row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="slider_name">Tên:</label>
              <input name="slider_name" type="text" class="form-control" id="slider_name" placeholder="Name" value="{{ $slider->slider_name or old('slider_name') }}" >
            </div>

            <div class="form-group">
              <label for="slider_image">Hình ảnh:</label>
              <img id="backendlogo-icon" src="{{ asset($slider->slider_image) }}" class="img-thumbnail" width="200" height="100" />

              <input type="hidden" name="slider_image" id="backendlogo" class="inputImg" value="{{ old('slider_image') }}" />
              <button type="button" class="btn btn-default" onclick="selectFileWithCKFinder('backendlogo', 'backendlogo-icon')">Chọn ảnh</button>


            </div>

            <div class="form-group">
              <label for="slider_btn_text">Tên nút bấm:</label>
              <input name="slider_btn_text" type="text" class="form-control" id="slider_btn_text" placeholder="Button Name" value="{{ $slider->slider_btn_text or old('slider_btn_text') }}" >
            </div>
            
            <div class="form-group">
              <label for="slider_btn_url">Đường dẫn của nút:</label>
              <input name="slider_btn_url" type="text" class="form-control" id="slider_btn_url" placeholder="Button Url" value="{{ $slider->slider_btn_url or old('slider_btn_url') }}" >
            </div>

            <div class="form-group">
              <label for="slider_text">Mô tả:</label>
              <textarea name="slider_text" id="slider_text" class="form-control" rows="5">{{ $slider->slider_text or old('slider_text') }}</textarea>
            </div>

            <div class="form-group">
              <label for="sort_order">Thứ tự:</label>
              <input name="sort_order" type="text" class="form-control" id="sort_order" placeholder="Sort Order" value="{{ $slider->sort_order or old('sort_order') }}" >
            </div>

            <div class="form-group">
              <label for="status" style="width: 100%">Trạng thái:</label>
              <input name="status" id="status" type="checkbox" value="1" data-toggle="toggle" style="display: none;" @if($slider->status == 1) checked="checked" @endif>
              <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                  <div class="Toggle"></div>
              </div>
            </div>

          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        {!! Form::close() !!}
      </div>

    </div>
  </div>
</section>
<!-- /.content -->
@endsection