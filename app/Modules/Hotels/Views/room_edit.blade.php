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
                    <h3 class="card-title">Thêm khách sạn(Điền đầy đủ thông tin bắt buộc)</h3>
                </div>
              <!-- /.card-header -->
                {!! Form::model($room, ['method' => 'PATCH','route' => ['room.update', $room->id],'enctype'=>'multipart/form-data']) !!}
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
                                                <label>Tên khách sạn(<span class="red">*</span>):</label>
                                                <input type="text" name="name" placeholder="Nhập tên tour" class="form-control" value="{{$room->name or old('name')}}" >
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
                                                        <img id="logo-icon" class="imgPreview" src="@if($room->avatar) {{url($room->avatar) }} @endif"/>
                                                        <input type="hidden" name="image" id="image" class="inputImg" value=""/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Diện tích(mét vuông):</label>
                                                <input type="number" name="room[acreage]" placeholder="Nhập diện tích phòng" class="form-control" value="{{$room->room['acreage'] or 0}}" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Số người tối đa(<span class="red">*</span>):</label>
                                                <input type="number" name="room[total]" placeholder="Nhập số người ở tối đa" class="form-control" value="{{$room->room['total'] or 0}}" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Số phòng ngủ(<span class="red">*</span>):</label>
                                                <input type="number" name="room[bedroom]" placeholder="Nhập số  phòng ngủ" class="form-control" value="{{$room->room['bedroom'] or 0}}" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Số phòng tắm:</label>
                                                <input type="number" name="room[bathroom]" placeholder="Nhập số  phòng tắm" class="form-control" value="{{$room->room['bathroom'] or 0}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Số giường đôi(<span class="red">*</span>):</label>
                                                <input type="number" name="room[bed2]" placeholder="Nhập số giường đôi" class="form-control" value="{{$room->room['bed2'] or 0}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Số giường đơn(<span class="red">*</span>):</label>
                                                <input type="number" name="room[bed1]" placeholder="Nhập số giường đơn" class="form-control" value="{{$room->room['bed1'] or 0}}">
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
                                                <textarea name="short_description" id="" cols="30" rows="6"  class="form-control">{{$room->short_description or old('short_description')}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="note">Miêu tả chi tiết(<span class="red">*</span>):</label>
                                                <textarea name="description" id="content" class="form-control"
                                                          rows="30" >{{$room->description or old('description') }}</textarea>
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
                                                <input type="text" name="price[{{$item->code}}]" class="form-control" placeholder="Nhập số giá  phòng" value="{{$room->price[$item->code] or 0}}">
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
                                                        <input type="text" name="fees[{{$item->code}}]" class="form-control" placeholder="Nhập số giá  phòng" value="{{$room->fees[$item->code] or 0}}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Khuyến mãi(%):</label>
                                                <input type="text" name="discount" class="form-control" placeholder="Khuyến mãi theo %" value="{{$room->discount or old('discount')}}">
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
                                                                    <input name="service[basic][]" value="{{$item->id}}" type="checkbox" id="{{$item->id}}" @if($room->service['basic']) @if(in_array($item->id, $room->service['basic'])) checked @endif @endif ><label for="{{$item->id}}">{{$item->name}}</label>
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
                                                            <input name="service[convenient][]" value="{{$item->id}}" type="checkbox" id="{{$item->id}}" @if($room->service['convenient']) @if(in_array($item->id, $room->service['convenient'])) checked @endif @endif ><label for="{{$item->id}}">{{$item->name}}</label>
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
                                                            <input name="service[other][]" value="{{$item->id}}" type="checkbox" id="{{$item->id}}" @if($room->service['other']) @if(in_array($item->id, $room->service['other'])) checked @endif @endif ><label for="{{$item->id}}">{{$item->name}}</label>
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
                                        @if(count($files)>0)
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
                                                                <button data-id="{{$file->id}}"  type="button" class=" btn-images btn btn-danger"><i title="Delete" class="btn btn-danger ace-icon fa fa-trash-o bigger-130"></i></button> </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <div class="form-group">
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-md-12" style="padding-top: 50px">
                                            <div class="form-group">
                                                <label for="status">Trạng thái:</label>
                                                <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" checked="checked" @if($room->status == 1) checked="checked" @endif>
                                                <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                                                    <div class="Toggle"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="padding-top: 50px; text-align: center">
                                            <div class="card-footer">
                                                <button type="button" class="btn btn-outline-primary" id="btn-pre5" style=" margin: 10px"><< Pre</button>
                                                <button type="submit" class="btn btn-primary" style=" margin: 10px"><i class="fa fa-pencil"> </i> Cập nhật</button>
                                                <a href="{{ url($backendUrl.'/room/'.$room->hotel_id) }}" class="btn btn-warning" style=" margin: 10px"><i class="fa fa-times" aria-hidden="true"></i> Đóng</a>
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
        $(document).ready(function() {

            $(".btn-images").on('click', (function(e){
                    $("#wait").css("display", "block");

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
                        $("#wait").css("display", "none");
                    }
                });
            }));
        });

    </script>
@endsection
