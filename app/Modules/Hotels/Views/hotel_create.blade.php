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
                <h3 class="card-title">Thêm lý do cho tạo phiếu</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::open(array('route' => 'hotel.store','method'=>'POST')) !!}
                <div class="card-body row">
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="type">Tên khách sạn:</label>
                                    <input name="name" type="text" required class="form-control" id="code" placeholder="Nhập tên khách sạn" value="{{ old('name') }}" >
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
                                            <input type="hidden" name="image" id="image" class="inputImg" value="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class=" form-group">
                                    <label for="city">Tỉnh/Thành(<span class="red">*</span>):</label>
                                    <select class="form-control" name="city" id="cities" >
                                        <option value="">-- Chọn tỉnh/thành phố--</option>
                                        @foreach ($cities as $item)
                                            <option value="{{$item->code}}"> {{$item->name_city}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="province">Quận huyện(<span class="red">*</span>):</label>
                                    <select class="form-control" name="province" id="provinces" >
                                        <option value="">-- Chọn quận/uyện --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Địa chỉ củ thể(<span class="red">*</span>):</label>
                                    <input  type="text" name="address" class="form-control" placeholder="Nhập địa chỉ" value="{{old('address')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-top: 20px">
                            <div class="form-group">
                                <label >Chọn ảnh(<span class="red">*</span>):</label>
                                <input type="file" multiple name="images[]" id="file-input" class="form-control" style="border: none" value="">
                                <div id="preview" class="col-md-12" style="border: 1px solid gray"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Miêu tả ngắn:</label>
                                <textarea name="short_description" id="" cols="30" rows="6"  class="form-control">{{old('short_description')}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="note">Miêu tả chi tiết(<span class="red">*</span>):</label>
                                <textarea name="description" id="content" class="form-control"
                                          rows="30" >{{ old('description') }}</textarea>
                            </div>
                        </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="tags">Tags:</label>
                                    <select name="tags[]" id="tags" class="form-control select2"
                                            multiple="multiple" data-placeholder="Select a Tag">
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->label }}</option>
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
                                    <label for="tags">Add New Tag:</label>
                                    <input name="new_tags" type="text" class="form-control" id="new_tags"
                                           value="{{ old('new_tags') }}">
                                    <p class="help-block">Tag seperator by "<b>,</b>" .Example:
                                        tag1,tag2....</p>
                                </div>

                            </div>
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="featured" style="padding-right: 15px">Nổi bật:</label>
                            <input name="featured" id="featured" type="checkbox" value="featured" data-toggle="toggle" style="display: none;" checked="checked">
                            <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                                <div class="Toggle"></div>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
                <!-- /.card-body -->
                    <div class="col-md-12">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" style=" margin: 10px"><i class="fa fa-plus-circle"> </i> Thêm</button>
                            <a href="{{route('hotel.index')}}" class="btn btn-warning" style=" margin: 10px"><i class="fa fa-times" aria-hidden="true"></i> Đóng</a>
                        </div>
                    </div>
                    @csrf
                {!! Form::close() !!}
            </div>
            <!-- /.card -->
              </div>
              <!-- /.card-body -->
            </div>
    <!-- /.card -->

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
