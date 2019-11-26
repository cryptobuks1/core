@extends('master')

@section('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker-bs3.css') }}">
@endsection
@section('js')
  @include('ckfinder::setup')
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
                <h3 class="card-title">Sửa tin tức</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::model($news, ['method' => 'PATCH','route' => ['news.update', $news->id],'enctype' => 'multipart/form-data']) !!}
                <div class="card-body row">
                  <div class="col-md-12">
                    <div class="form-group row">
                      <div class="col-md-6">
                        <label for="title">Tiêu đề:</label>
                        <input name="title" type="text" class="form-control" id="title" placeholder="Title" value="{{ $news->title or old('title') }}" >
                      </div>
                      <div class="col-md-6">
                        <label for="news_slug">Đường dẫn SEO:</label>
                        <input name="news_slug" type="text" class="form-control" id="news_slug" placeholder="Đường dẫn SEO" value="{{ $news->news_slug or old('news_slug') }}">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-md-4">
                        <label for="author">Tác giả:</label>
                        <input name="author" type="text" class="form-control" id="author" value="{{ $news->author }}" readonly="">
                      </div>
                      <div class="col-md-4">
                        <label for="author_email">Email:</label>
                        <input name="author_email" type="text" class="form-control" id="author_email" value="{{ $news->author_email }}" readonly="">
                      </div>
                      <div class="col-md-4">
                        <label for="url">Ảnh:</label>
                        <div class="row">
                          <div class="col-md-6">
                            <button type="button" class="btn btn-default"
                                    onclick="selectFileWithCKFinder('image', 'logo-icon')">Chọn ảnh
                            </button>
                          </div>
                          <div class="col-md-6">
                            <img id="logo-icon" class="imgPreview" src="@if($news->image){{ url($news->image) }}@endif"/>
                            <input type="hidden" name="image" id="image" class="inputImg" value=""/>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-md-3">
                        <label for="language">Lượt xem:</label>
                        <input name="view_count" type="text" class="form-control" id="view_count" value="{{ $news->view_count }}" >
                      </div>
                      <div class="col-md-3">
                        <label for="language">Ngôn ngữ:</label>
                        <select class="form-control" name="language">
                          @if(count($languages) > 0)
                            @foreach($languages as $lang)
                              <option value="{{$lang['code']}}" @if($lang['code'] == $news->language) selected @endif>{{$lang['name']}}</option>
                            @endforeach
                          @endif
                        </select>

                      </div>
                      <div class="col-md-3">
                        <label for="publish_date">Ngày đăng:</label>
                        <input name="publish_date" type="text" class="form-control" id="publish_date" value="{{ $news->publish_date or old('publish_date') }}">

                      </div>
                      <div class="col-md-3">
                        <label for="status">Trạng thái:</label>
                        <select class="form-control" name="status" id="status">
                          <option value="1" @if($news['status'] == 1) selected="selected" @endif>Bật</option>
                          <option value="0" @if($news['status'] == 0) selected="selected" @endif>Tắt</option>
                        </select>
                      </div>

                    </div>

                    <div class="form-group">
                      <label for="short_description">Mô tả ngắn:</label>
                      <textarea name="short_description" id="short_description" class="form-control" rows="3">{{ $news->short_description or old('short_description') }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="content">Nội dung:</label>
                      <textarea name="content" id="content" class="form-control" rows="10" cols="80">{{ $news->content or old('content') }}</textarea>

                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="tags">Tags:</label>
                          <select name="tags[]" id="tags" class="form-control select2" multiple="multiple" data-placeholder="Select a Tag" >
                            @foreach($tags as $tag)
                              <option value="{{ $tag->id }}" @if(in_array($tag->id, $selected_tags)) selected="selected" @endif>{{ $tag->label }}</option>
                            @endforeach
                          </select>
                        </div>
                        <script type="text/javascript">
                          $(function () {
                            //Initialize Select2 Elements
                            $('.select2').select2();
                          })
                        </script>
                        <div class="col-md-6">
                          <label for="tags">Thêm Tag mới:</label>
                          <input name="new_tags" type="text" class="form-control" id="new_tags" value="{{ old('new_tags') }}">
                          <p class="help-block">Tag seperator by "<b>,</b>" .Example: tag1,tag2....</p>
                        </div>
                      </div>
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