@extends('master')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
    <style>
        .red{
            color: red;
        }
        #preview img{
            padding: 10px;
        }
    </style>
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
                <h3 class="card-title">Thêm hãng bay</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::open(array('route' => 'flight.airline.store','method'=>'POST','enctype' => 'multipart/form-data')) !!}
                <div class="card-body row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tên hãng bay(<span class="red">*</span>):</label>
                            <input type="text" name="name" class="form-control" placeholder="Nhập tên hãng bay" required value="{{old('name')}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="url">Ảnh đại diện(<span class="red">*</span>):</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-default"
                                            onclick="selectFileWithCKFinder('image', 'logo-icon')">Chọn ảnh
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <img id="logo-icon" class="imgPreview" src="{{ old('image') }}"/>
                                    <input type="hidden" name="image" id="image" class="inputImg" value="" required/>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Loại hãng bay(<span class="red">*</span>):</label>
                            <select name="local" id="" class="form-control">
                                <option value="1">Hãng bay trong nước</option>
                                <option value="2">Hãng bay ngoài nước</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mã code hãng bay(<span class="red">*</span>):</label>
                            <input type="text" name="code" id="" class="form-control" placeholder="Nhập mã code" style="text-transform: uppercase" maxlength="10" required value="{{old('code')}}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Trạng thái:</label>
                            <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" checked="checked" >
                            <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                                <div class="Toggle"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="note">Mô tả(<span class="red">*</span>):</label>
                            <textarea name="description" id="content" class="form-control"
                                      rows="30" required>{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                <input type="file" name="importFile" id="importFile" class="form-control-file">
                <!-- /.card-body -->
                    <div class="col-md-12">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" style=" margin: 10px"><i class="fa fa-plus-circle"> </i> Thêm</button>
                            <a href="{{route('flight.airline.index')}}" class="btn btn-warning" style=" margin: 10px"><i class="fa fa-times" aria-hidden="true"></i> Đóng</a>
                        </div>
                    </div>
                    @csrf
                {!! Form::close() !!}
            </div>
            <!-- /.card -->
      </div>
    </div>
  </div>

</section>
<!-- /.content -->
@endsection
@section('js')
    @include('ckfinder::setup')
    <script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/ckeditor4101/ckeditor.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script>
        $(function () {
            CKEDITOR.replace('content', {
                filebrowserBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
                filebrowserImageBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
                filebrowserFlashBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
            });
            CKEDITOR.config.extraPlugins = 'justify , colorbutton';
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $("#cities").on('change', (function(e){
                var city_code = $(this).val();
                $.ajax({
                    type:'POST',
                    url:'{{ route('ajax.cities') }}',
                    data:{code:city_code},
                    success:function(data){
                        $('#provinces').html(data);
                    }
                });
            }));
            function previewImages() {
                var $preview = $('#preview').empty();
                if (this.files) $.each(this.files, readAndPreview);
                function readAndPreview(i, file) {
                    if (!/\.(jpe?g|png|gif)$/i.test(file.name)){
                        return alert(file.name +" is not an image");
                    } // else...
                    var reader = new FileReader();
                    $(reader).on("load", function() {
                        $preview.append($("<img/>", {src:this.result, height:170}));
                    });
                    reader.readAsDataURL(file);
                }
            }

            $('#file-input').on("change", previewImages);
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
                        if (data) {
                            $("#news_slug").attr('value', data);
                        }
                    }

                });

            });
        });


    </script>
@endsection
