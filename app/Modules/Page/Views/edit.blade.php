@extends('master')

@section('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker-bs3.css') }}">
@endsection
@section('js')
<script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jQueryUI/jquery-ui.min.1.12.1.js') }}"></script>

<script src="{{ asset('adminlte/plugins/ckeditor4101/ckeditor.js') }}"></script>
<script>
  $(function() {
    CKEDITOR.replace( 'content', {
      filebrowserBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
      filebrowserImageBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
      filebrowserFlashBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
    } );
    CKEDITOR.config.extraPlugins = 'justify , colorbutton';
  });
</script>

@endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="col-md-12">
            <!-- general form elements -->

           @include('layouts.errors')

            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Sửa trang tĩnh</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::model($staticPage, ['method' => 'PATCH','route' => ['pages.update', $staticPage->id],'enctype' => 'multipart/form-data']) !!}
                <div class="card-body row">
                  <div class="col-md-12">
                    <div class="form-group row">
                      <div class="col-md-6">
                        <label for="title">Tiêu đề:</label>
                        <input name="title" type="text" class="form-control" id="title" placeholder="Title" value="{{ $staticPage->title or old('title') }}" >
                      </div>
                      <div class="col-md-6">
                        <label for="news_slug">Đường dẫn url:</label>
                        <input name="slug" type="text" class="form-control" id="news_slug" placeholder="Đường dẫn url" value="{{ $staticPage->slug or old('slug') }}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-3">
                        <label for="language">Ngôn ngữ:</label>
                        <select class="form-control" name="language">
                          @if(count($languages) > 0)
                            @foreach($languages as $lang)
                              <option value="{{$lang['code']}}" @if($lang['code'] == $staticPage->language) selected @endif>{{$lang['name']}}</option>
                            @endforeach
                          @endif
                        </select>

                      </div>
                      <div class="col-md-3">
                        <label for="status">Trạng thái:</label>
                        <select class="form-control" name="status" id="status">
                          <option value="1" @if($staticPage['status'] == 1) selected="selected" @endif>Bật</option>
                          <option value="0" @if($staticPage['status'] == 0) selected="selected" @endif>Tắt</option>
                        </select>
                      </div>

                    </div>

                    <div class="form-group">
                      <label for="content">Nội dung:</label>
                      <textarea name="description" id="content" class="form-control" rows="10" cols="80">{{ $staticPage->description or old('description') }}</textarea>

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