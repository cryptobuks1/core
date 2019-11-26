@extends('master')

@section('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker-bs3.css') }}">
@endsection
@section('js')
<script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>

<script src="{{ asset('adminlte/plugins/ckeditor4101/ckeditor.js') }}"></script>
<script>
  $(function () {
    CKEDITOR.replace('description', {
      filebrowserBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
      filebrowserImageBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
      filebrowserFlashBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
    });
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
                <h3 class="card-title">Tạo trang mới</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::open(array('route' => 'pages.store','method'=>'POST', 'enctype' => 'multipart/form-data')) !!}
                <div class="card-body row">
                  <div class="col-md-12">
                    <div class="form-group row">
                      <div class="col-md-6">
                        <label for="title">Tiêu đề:</label>
                        <input name="title" type="text" class="form-control" id="title" placeholder="Tiêu đề" value="{{ old('title') }}" >

                      </div>
                      <div class="col-md-6">
                        <label for="slug">Đường dẫn SEO:</label>
                        <input name="slug" type="text" class="form-control" id="slug" placeholder="Đường dẫn Url" value="{{ old('slug') }}">
                      </div>
                   </div>

                    <div class="form-group row">
                      <div class="col-md-3">
                        <label for="language">Ngôn ngữ:</label>
                        <select class="form-control" name="language">
                          @if(count($languages) > 0)
                            @foreach($languages as $lang)
                              <option value="{{$lang['code']}}">{{$lang['name']}}</option>
                            @endforeach
                          @endif
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label for="status">Trạng thái:</label>
                        <select class="form-control" name="status" id="status">
                          <option value="1" selected="selected">Bật</option>
                          <option value="0">Tắt</option>
                        </select>
                      </div>


                    </div>


                    <div class="form-group">
                      <label for="short_description">Mô tả ngắn:</label>
                      <textarea name="short_description" id="short_description" class="form-control" rows="2">{{ old('short_description') }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="description">Nội dung:</label>
                      <textarea name="description" id="description" class="form-control" rows="30">{{ old('description') }}</textarea>
                    </div>
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Thêm mới</button>
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


<script type="text/javascript">
  $(document).ready(function () {

    $('#title').focusout(function () {
      var pname = $(this).val();
      $.ajax({
        url: '{{url('/').'/'.$backendUrl.'/make/ajaxslug'}}',
        method: "post",
        data: {
          title: pname,
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
          if(data){
            $("#slug").attr('value', data);
          }
        }

      });

    });
  });

</script>
@endsection