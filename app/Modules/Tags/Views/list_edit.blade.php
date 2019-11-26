@extends('master')

@section('css')
@endsection
@section('js')
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
                <h3 class="card-title">Sửa Tag: {{ $tag->label }}</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::model($tag, ['method' => 'PATCH','route' => ['tagslist.update', $tag->id]]) !!}
                <div class="card-body row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="title">Tên Tag:</label>
                      <input name="label" type="text" class="form-control" id="label" placeholder="Tag Label" value="{{ $tag->label or old('label') }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="url">Người tạo:</label>
                      <input name="author" type="text" class="form-control" id="author" value="{{ $tag->author }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="description">Mô tả:</label>
                      <textarea name="description" id="description" class="form-control" rows="10">{{ $tag->description or old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="module">Module:</label>
                      <input name="module" type="text" class="form-control" placeholder="Tên của mô-đun" id="module" value="{{ $tag->module }}">
                    </div>
                    <div class="form-group">
                      <label for="model">Model:</label>
                      <input name="model" type="text" class="form-control" id="model" placeholder="Tên của Model thao tác với CSDL" value="{{ $tag->model }}">
                    </div>
                    <div class="form-group">
                      <label for="model_id">Model ID:</label>
                      <input name="model_id" type="text" class="form-control" id="model_id" placeholder="ID của dòng trong CSDL" value="{{ $tag->model_id }}">
                    </div>
                    <div class="form-group">
                      <label for="status">Trạng thái:</label>
                      <select class="form-control" name="status" id="status">
                        <option value="1" @if($tag['status'] == 1) selected="selected" @endif>Bật</option>
                        <option value="0" @if($tag['status'] == 0) selected="selected" @endif>Tắt</option>
                      </select>
                    </div>
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Cập nhật</button>
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