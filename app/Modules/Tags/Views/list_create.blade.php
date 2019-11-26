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
                <h3 class="card-title">Create Tag</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <!-- <form action="{{ url($backendUrl.'/tags/list/store') }}" method="POST"> -->
              {!! Form::open(array('route' => 'tagslist.store','method'=>'POST')) !!}
                <div class="card-body row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="label">Tên Tag:</label>
                      <input name="label" type="text" class="form-control" id="label" placeholder="Ví dụ: quần áo thể thao" value="{{ old('label') }}" >
                    </div>
                    <div class="form-group">
                      <label for="author">Người tạo:</label>
                      <input name="author" type="text" class="form-control" id="author" value="{{ $author }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="description">Mô tả tag:</label>
                      <textarea name="description" id="description" class="form-control" rows="10">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                      <label for="module">Module:</label>
                      <input name="module" type="text" class="form-control" placeholder="Tên của mô-đun" id="module" value="{{ old('module') }}">
                    </div>
                    <div class="form-group">
                      <label for="model">Model:</label>
                      <input name="model" type="text" class="form-control" placeholder="Tên của Model thao tác với CSDL" id="model" value="{{ old('model') }}">
                    </div>
                    <div class="form-group">
                      <label for="model_id">Model ID:</label>
                      <input name="model_id" type="text" class="form-control" placeholder="ID của dòng trong CSDL" id="model_id" value="{{ old('model_id')}}">
                    </div>
                    <div class="form-group">
                      <label for="status">Trạng thái:</label>
                      <select class="form-control" name="status" id="status">
                        <option value="1" selected="selected">Bật</option>
                        <option value="0">Tắt</option>
                      </select>
                    </div>
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Thêm</button>
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