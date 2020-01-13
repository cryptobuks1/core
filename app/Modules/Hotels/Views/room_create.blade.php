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
        input[type=checkbox] {
            display:none;
        }

        label {
            display: block;
            width: 200px;
            margin: 0 auto;
            margin-top: 10px;
        }

        label:hover {
            cursor: pointer;
        }

        input[type=checkbox] + label:before {
            content: '';
            display: inline-block;
            border: 2px solid #0F81D5;
            margin-right: 10px;
            height: 12px;
            width: 12px;
            vertical-align: middle;
            transition: all .1s linear;

        }

        input[type=checkbox]:checked + label:before {
            border-left-width: 5px;
            border-bottom-width: 5px;
            border-top-width: 0px;
            border-right-width: 0px;
            transform: rotate(-45deg) translate(2px, -2px);
            height: 6px;
            width: 11px;
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
                    <h3 class="card-title">Thêm phòng cho khách sạn</h3>
                </div>
              <!-- /.card-header -->
                {!! Form::open(array('route' => ['room.store',$hotel_id],'method'=>'POST','enctype'=>'multipart/form-data')) !!}
                    <div class="card-body row">
                        <div class="col-md-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active menu1" data-toggle="tab" href="#menu1"><h5>Thông tin cơ bản</h5></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu2" data-toggle="tab" href="#menu2"><h5>Mô tả</h5></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu3" data-toggle="tab" href="#menu3"><h5>Giá cả</h5></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu4" data-toggle="tab" href="#menu4"><h5>Dịch vụ</h5></a>
                                </li>
                                <li class="nav-item menu5">
                                    <a class="nav-link" data-toggle="tab" href="#menu5"><h5>Hình ảnh</h5></a>
                                </li>
                            </ul>
                            <br>
                            <br>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div id="menu1" class="container tab-pane active"><br>
                                    <h3>Thông tin phòng(<span class="red">*</span>)</h3>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Tên phòng(<span class="red">*</span>):</label>
                                                <input type="text" name="name" placeholder="Nhập tên tour" class="form-control" value="{{old('name')}}" >
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Diện tích-mét vuông(<span class="red">*</span>):</label>
                                                <input type="number" name="room[acreage]" placeholder="Nhập diện tích phòng" class="form-control" value="0" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Số người tối đa(<span class="red">*</span>):</label>
                                                <input type="number" name="room[total]" placeholder="Nhập số người tối đa" class="form-control" value="0"  >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Số phòng ngủ(<span class="red">*</span>):</label>
                                                <input type="number" name="room[bedroom]" placeholder="Nhập số phòng ngủ" class="form-control" value="0" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Số phòng tắm(<span class="red">*</span>):</label>
                                                <input type="number" name="room[bathroom]" placeholder="Nhập số phòng tắm" class="form-control" value="0">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Số giường đôi(<span class="red">*</span>):</label>
                                                <input type="number" name="room[bed2]" placeholder="Nhập số giường đôi" class="form-control" value="0">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Số giường đơn(<span class="red">*</span>):</label>
                                                <input type="number" name="room[bed1]" placeholder="Nhập số giường đơn" class="form-control" value="0">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary" id="btn-menu1" style="float:right; margin: 10px">Next >></button>
                                        </div>

                                    </div>
                                </div>
                                <div id="menu2" class="container tab-pane fade"><br>
                                    <h3>Mô tả(<span class="red">*</span>)</h3>
                                    <div class="row">
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
                                            <button type="button" class="btn btn-primary" id="btn-menu2" style="float:right; margin: 10px">Next >></button>
                                            <button type="button" class="btn btn-outline-primary" id="btn-pre2" style="float:right; margin: 10px"><< Pre</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="menu3" class="container tab-pane fade"><br>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3>Giá phòng(<span class="red">*</span>)</h3>
                                        </div>
                                        @if(count($currencies)>0)
                                            @foreach($currencies as $item)
                                                <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Giá phòng({{$item->code}}):</label>
                                                <input type="text" name="price[{{$item->code}}]" class="form-control" placeholder="Nhập số giá  phòng" value="0">
                                            </div>
                                        </div>
                                            @endforeach
                                        @endif

                                        <div class="col-md-12">
                                            <br>
                                            <h3>Phí phát sinh</h3>
                                        </div>
                                        @if(count($currencies)>0)
                                            @foreach($currencies as $item)
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Phí phát sinh({{$item->code}}):</label>
                                                        <input type="text" name="fees[{{$item->code}}]" class="form-control" placeholder="Nhập số giá  phòng" value="0">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Khuyến mãi(%):</label>
                                                <input type="text" name="discount" class="form-control" placeholder="Khuyến mãi theo %" value="0">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary" id="btn-menu3" style="float:right; margin: 10px">Next >></button>
                                            <button type="button" class="btn btn-outline-primary" id="btn-pre3" style="float:right; margin: 10px"><< Pre</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="menu4" class="container tab-pane fade"><br>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h4>Dịch vụ cơ bản</h4>
                                                        @foreach($services as $key => $item)
                                                            @if($item->type_services == 'basic')
                                                                <div>
                                                                    <input name="service[basic][]" value="{{$item->id}}" type="checkbox" id="{{$item->id}}"><label for="{{$item->id}}">{{$item->name}}</label>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h4>Dịch vụ tiện nghi</h4>
                                                @foreach($services as $key => $item)
                                                    @if($item->type_services == 'convenient')
                                                        <div>
                                                            <input name="service[convenient][]" value="{{$item->id}}" type="checkbox" id="{{$item->id}}"><label for="{{$item->id}}">{{$item->name}}</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <h4>Dịch vụ khác</h4>
                                                @foreach($services as $key => $item)
                                                    @if($item->type_services == 'other')
                                                        <div>
                                                            <input name="service[other][]" value="{{$item->id}}" type="checkbox" id="{{$item->id}}"><label for="{{$item->id}}">{{$item->name}}</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary" id="btn-menu4" style="float:right; margin: 10px">Next >></button>
                                            <button type="button" class="btn btn-outline-primary" id="btn-pre4" style="float:right; margin: 10px"><< Pre</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="menu5" class="container tab-pane fade"><br>
                                    <h3>Hình ảnh(<span class="red">*</span>)</h3>
                                    <div class="row">
                                        <div class="col-md-12" style="padding-top: 20px">
                                            <div class="form-group">
                                                <label >Chọn ảnh(<span class="red">*</span>):</label>
                                                <input type="file" multiple name="images[]" id="file-input" class="form-control" style="border: none" value="">
                                                <div id="preview" class="col-md-12" style="border: 1px solid gray"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="padding-top: 50px">
                                            <div class="form-group">
                                                <label for="status">Trạng thái:</label>
                                                <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" checked="checked">
                                                <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                                                    <div class="Toggle"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="padding-top: 50px; text-align: center">
                                            <div class="card-footer">
                                                <button type="button" class="btn btn-outline-primary" id="btn-pre5" style=" margin: 10px"><< Pre</button>
                                                <button type="submit" class="btn btn-primary" style=" margin: 10px"><i class="fa fa-plus-circle"> </i> Thêm</button>
                                                <a href="{{ url($backendUrl.'/room/'.$hotel_id) }}" class="btn btn-warning" style=" margin: 10px"><i class="fa fa-times" aria-hidden="true"></i> Đóng</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                <!-- /.card-body -->

                {!! Form::close() !!}
            </div>
            <!-- /.card -->
              </div>

            <!-- /.card-body -->
      </div>
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
        });
        $(document).ready(function() {
            $("#btn-menu1").on('click', (function (e) {
                $('#menu1').removeClass('active show');
                $('.menu1').removeClass('active show');

                $('#menu2').addClass('active show');
                $('.menu2').addClass('active show');
            }));
            $("#btn-menu2").on('click', (function (e) {
                $('#menu2').removeClass('active show');
                $('.menu2').removeClass('active show');

                $('#menu3').addClass('active show');
                $('.menu3').addClass('active show');
            }));
            $("#btn-menu3").on('click', (function (e) {
                $('#menu3').removeClass('active show');
                $('.menu3').removeClass('active show');

                $('#menu4').addClass('active show');
                $('.menu4').addClass('active show');
            }));
            $("#btn-menu4").on('click', (function (e) {
                $('#menu4').removeClass('active show');
                $('.menu4').removeClass('active show');

                $('#menu5').addClass('active show');
                $('.menu5').addClass('active show');
            }));
        });
        $(document).ready(function() {
            $("#btn-pre2").on('click', (function (e) {
                $('#menu2').removeClass('active show');
                $('.menu2').removeClass('active show');

                $('#menu1').addClass('active show');
                $('.menu1').addClass('active show');
            }));
            $("#btn-pre3").on('click', (function (e) {
                $('#menu3').removeClass('active show');
                $('.menu3').removeClass('active show');

                $('#menu2').addClass('active show');
                $('.menu2').addClass('active show');
            }));
            $("#btn-pre4").on('click', (function (e) {
                $('#menu4').removeClass('active show');
                $('.menu4').removeClass('active show');

                $('#menu3').addClass('active show');
                $('.menu3').addClass('active show');
            }));
            $("#btn-pre5").on('click', (function (e) {
                $('#menu5').removeClass('active show');
                $('.menu5').removeClass('active show');

                $('#menu4').addClass('active show');
                $('.menu4').addClass('active show');
            }));
        });

    </script>
@endsection
