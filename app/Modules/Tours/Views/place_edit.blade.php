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
                <h3 class="card-title">Chỉnh sửa</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                {!! Form::model($place, ['method' => 'PATCH','route' => ['tour.place.update', $place->id],'enctype'=>'multipart/form-data']) !!}
                <div class="card-body row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <h4 style="color: #00aced">Thông tin chung</h4>
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Tên địa điểm(<span class="red">*</span>):</label>
                                <input name="name" type="text" required class="form-control" id="code" placeholder="Nhập tên" value="{{ $place->name or old('name') }}" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Địa điểm du lịch(<span class="red">*</span>):</label>
                                <select name="type" id="tour-type" class="form-control" required>
                                    <option value="">--Nhấp chọn--</option>
                                    <option value="domestic" @if($place->type == 'domestic') selected @endif>Du lịch trong nước</option>
                                    <option value="foreign" @if($place->type == 'foreign') selected @endif>Du lịch nước ngoài</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Chọn loại Tour(<span class="red">*</span>):</label>
                                <select name="type_tour" id="tour-type2" class="form-control">
                                    <option value="">--Nhấp chọn--</option>
                                    @foreach($type as $item)
                                        <option value="{{$item->id}}" @if($item->id == $place->type_tour) selected @endif>{{$item->name}}</option>
                                    @endforeach
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
                                        <option value="{{$item->code}}" @if($item->code == $place->country) selected @endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <label>Tỉnh/Thành(<span class="red">*</span>):</label>
                                <select class="form-control" name="city" id="cities" style="height: 35px;">
                                    <option value="" >-- Chọn tỉnh/thành phố --</option>
                                    @foreach ($cities as $item)
                                        <option value="{{$item->code}}" @if($item->code == $place->city) selected @endif> {{$item->name_city}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Quận/huyện:</label>
                                <select class="form-control" name="province" id="provinces" style="height: 35px;">
                                    <option value="">-- Chọn quận\huyện --</option>
                                    @foreach ($provinces as $item)
                                        <option value="{{$item->name}}" @if($item->name == $place->province) selected @endif> {{$item->name}} </option>
                                    @endforeach
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
                                    <img id="logo-icon" class="imgPreview" src="@if($place->avatar){{ url($place->avatar)}}@endif "/>
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
                        <label for="">Danh sách ảnh:</label>
                        <table id="example1" class="table table-bordered table-striped dataTable">
                            <tr style="text-align: center">
                                <th>file</th>
                                <th>xóa</th>
                            </tr>
                            <tbody>
                                @foreach($files as $key=>$file)
                                    @if(isset($file->name))
                                        <tr>
                                            <td><img src="{{asset('storage/avatar/'.$file->name)}}" height="70" width="80"></td>
                                            <td style="text-align: center">
                                                <button data-id="{{$file->id}}" data-key="{{$place->id}}" type="button" class=" btn-images btn btn-danger"><i title="Delete" class="btn btn-danger ace-icon fa fa-trash-o bigger-130"></i></button> </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div class="form-group">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Mô tả tóm tắt:</label>
                            <textarea name="short_description" id="" cols="30" rows="6"  class="form-control">{{$place->short_description or old('short_description')}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Mô tả chi  tiết(<span class="red">*</span>):</label>
                            <textarea name="description" id="content" class="form-control"
                                      rows="">{{$place->description or old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="status">Trạng thái:</label>
                            <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" @if($place->status == 1) checked="checked" @endif>
                            <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                                <div class="Toggle"></div>
                            </div>
                        </div>
                    </div>
                <!-- /.card-body -->
                    <div class="col-md-12">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
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
    <div id="wait" style="display:none;width:69px;height:69px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='data:image/png;base64,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' width="64" height="64" /><br>Loading..</div>

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
        $(document).ready(function() {
            $(document).ajaxStart(function(){
                $("#wait").css("display", "block");
            });
            $(document).ajaxComplete(function(){
                $("#wait").css("display", "none");
            });
            $(".btn-images").on('click', (function(e){
                var code= $(this).attr('data-id');
                var key = $(this).attr('data-key');
                var a= $(this).parent().parent();
                $.ajax({
                    type:'POST',
                    url:'{{ route('ajax.tour.delimages') }}',
                    data:{code:code, key:key},
                    dataType:'json',
                    success:function(data){
                        a.remove();
                    }
                });
            }));
        });

    </script>
@endsection
