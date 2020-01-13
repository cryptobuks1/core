@extends('master')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
    <style>
        .red   {
            color: red;
        }
        #preview img{
            padding: 10px;
        }
    </style>
@endsection
@section('js')
    @include('ckfinder::setup')
    <script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/ckeditor4101/ckeditor.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script !src="">
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
            $("#tour-type").on('change', (function(e){
                var code= $(this).val();
                $.ajax({
                    type:'POST',
                    url:'{{ route('ajax.tour.type') }}',
                    data:{code:code},
                    success:function(data){
                        $('#tour-type2').html(data);
                    }
                });
                $('#tour-type').each(function() {
                    if ($(this).val() == 'domestic') {
                        $('.countries').hide();
                        $('#countries').val('VN');
                        $('.an').val('');
                    } else if ($(this).val() == 'foreign') {
                        $('.countries').show();
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
        });

        $(document).ready(function() {
            $("#countries").on('change', (function(e){
                var countries = $(this).val();
                $.ajax({
                    type:'POST',
                    url:'{{ route('ajax.tour.countries') }}',
                    data:{code:countries},
                    success:function(data){
                        $('#cities').html(data);
                    }
                });
            }));
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">ADD Địa Điểm Du Lịch</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                {!! Form::open(array('route' => 'tour.place.store','method'=>'POST','enctype'=>'multipart/form-data')) !!}
                <div class="card-body row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <h4 style="color: #00aced">Thông tin chung</h4>
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Tên địa điểm(<span class="red">*</span>):</label>
                                <input name="name" type="text" required class="form-control" id="code" placeholder="Nhập tên" value="{{ old('name') }}" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Địa điểm du lịch(<span class="red">*</span>):</label>
                                <select name="type" id="tour-type" class="form-control" required>
                                    <option value="">--Nhấp chọn--</option>
                                    <option value="domestic">Du lịch trong nước</option>
                                    <option value="foreign">Du lịch nước ngoài</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Chọn loại Tour(<span class="red">*</span>):</label>
                                <select name="type_tour" id="tour-type2" class="form-control">
                                    <option value="">--Nhấp chọn--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <h4 style="color: #00aced">Thông tin địa lý</h4>
                            <hr>
                        </div>
                        <div class="col-md-12 countries">
                            <div class="form-group">
                                <label>Chọn quốc gia (<span class="red">*</span>):</label>
                                <select name="country" id="countries" class="form-control">
                                    <option value="">--Chọn quốc gia--</option>
                                    @foreach($countries as $item)
                                        <option value="{{$item->code}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <label>Tỉnh/Thành(<span class="red">*</span>):</label>
                                <select class="form-control" name="city" id="cities" style="height: 35px;">
                                    <option value="" >-- Chọn tỉnh/thành phố --</option>
                                    @foreach ($cities as $news)
                                        <option value="{{$news->code}}"> {{$news->name_city}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Quận/huyện:</label>
                                <select class="form-control" name="province" id="provinces" style="height: 35px;">
                                    <option value="">-- Chọn quận\huyện --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
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
                    <div class="col-md-12" style="padding-top: 20px">
                        <div class="form-group">
                            <label >Chọn ảnh:</label>
                            <input type="file" multiple name="images[]" id="file-input" class="form-control" style="border: none" value="">
                            <div id="preview" ></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Mô tả tóm tắt:</label>
                            <textarea name="short_description" id="" cols="30" rows="6"  class="form-control">{{old('short_description')}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Mô tả chi  tiết(<span class="red">*</span>):</label>
                            <textarea name="description" id="content" class="form-control"
                                      rows="30">{{ old('description') }}</textarea>
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
                <!-- /.card-body -->
                    <div class="col-md-12">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Thêm</button>
                            <a href="{{route('tour.place.index')}}" class="btn btn-warning">Đóng</a>
                        </div>
                    </div>
                    @csrf
                {!! Form::close() !!}
            </div>
            <!-- /.card -->
              </div>
              <!-- /.card-body -->
      </div>
    </div>
  </div>
</section>
<!-- /.content -->
@endsection
