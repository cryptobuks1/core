@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}"
          xmlns="http://www.w3.org/1999/html">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker-bs3.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <style>
        .form-control{
            font-size: 12px;
        }
        table td{
            font-size: 15px;
        }
        .red{
            color: red;
        }
        .blue{
            color: #00c0ef;
        }
        .header-min{
            background-color: #00c0ef;
        }
        .thumbnail{

            width: 200px;
            margin: 10px;
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
    <script src="{{ asset('adminlte/plugins/jQueryUI/jquery-ui.min.1.12.1.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/ckeditor4101/ckeditor.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function() {
            CKEDITOR.replace( 'content', {
                filebrowserBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
                filebrowserImageBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
                filebrowserFlashBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
            } );
            CKEDITOR.config.extraPlugins = 'justify , colorbutton';
        });
        function addNewImage() {
            let htmlImage = document.getElementById('html-image');
            let inputImage = document.createElement("input");

            inputImage.setAttribute('type', 'file');
            inputImage.setAttribute('name', 'filename[]');
            inputImage.setAttribute('multiple', '');
            htmlImage.appendChild(inputImage);
            inputImage.style.marginBottom = "20px";

        }

        function changeImg(input){
            //Nếu như tồn thuộc tính file, đồng nghĩa người dùng đã chọn file mới
            if(input.files && input.files[0]){
                var reader = new FileReader();
                //Sự kiện file đã được load vào website
                reader.onload = function(e){
                    //Thay đổi đường dẫn ảnh
                    $('#avatar').attr('src',e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).ready(function() {
            $('#avatar').click(function(){
                $('#img').click();
            });
        });
        $(document).ready(function() {
            $('#file').change(function(){
                var a =  $('#file').val();
                console.log(a);
                $('#filename').hide();

            });
        });

        $(document).ready(function(){
            $(".deleteClick").click(function(){
                var link = $(this).attr('link');
                var name = $(this).attr('name');
                $("#deleteForm").attr('action',link);
                $("#deleteMes").html("Delete : "+name+" ?");
            });
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
        });

        $(document).ready(function() {
            $("#provinces").on('change', (function(e){
                var province_code = $(this).val();
                $.ajax({
                    type:'POST',
                    url:'{{ route('ajax.province') }}',
                    data:{code:province_code},
                    success:function(data){
                        $('#project').html(data);
                    }
                });
            }));
        });

        $(document).ready(function() {
            $("#form").on('change', (function(e){
                var form_code = $(this).val();
                $.ajax({
                    type:'POST',
                    url:'{{ route('ajax.form') }}',
                    data:{code:form_code},
                    success:function(data){
                        $('#type').html(data);
                    }
                });
            }));
        });

        $(document).ready(function() {
            $("#vip").on('change', (function (e) {
                var vip = $('#vip').val();
                var end_date = $('#end_date').val();
                var end=$('#end').val();
                var start_date = $('#start_date').val();
                console.log(start_date);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.time') }}',
                    data: { vip: vip,end_date:end_date,start_date:start_date, end:end},
                    success: function (data) {
                        $('#end_date').html(data);
                    }
                });
            }));
        });
    </script>
    <script >
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
                        <div class="card-header ">
                            <h3 class="card-title">SỬA TIN RAO</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {!! Form::model($data, ['method' => 'PATCH','route' => ['realestates.update', $data->id],'enctype'=>'multipart/form-data']) !!}
                        <div class="card-body row">
                            <div class="card card-default col-md-12">
                                <div class="card-header header-min">
                                    <h3 class="card-title">Thông tin cơ bản</h3>
                                </div>
                                <div class="col-md-12" s>
                                    <div class=" row">
                                        <div class="col-md-12 col-xs-12">
                                            <div class="row" style="padding-top: 15px">
                                                <div class="col-md-1"><label for="">Tiêu đề(<span class="red">*</span>)</label></div>
                                                <div class="col-md-10 form-group" >
                                                    <input required type="text"  name="title" class="form-control" value="{{$data->title}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-2"><label>Hình thức</label>(<span class="red">*</span>)</div>
                                                <div class="col-md-8 form-group">
                                                    <select name="form" class="form-control" id="form">
                                                        <option value="1" @if($data->form==1)selected @endif>Nhà đất bán</option>
                                                        <option value="2" @if($data->form==2)selected @endif>Nhà đất cho thuê</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-2"> <label>Loại</label> (<span class="red">*</span>)</div>
                                                <div class="col-md-8 form-group">
                                                    <select name="type" class="form-control" id="type" >
                                                        @foreach ($types as $item)
                                                            <option value="{{$item->name}}" @if($data->type==$item->name)selected @endif> {{$item->name}} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-2"><label>Tỉnh/Thành</label>(<span class="red">*</span>)</div>
                                                <div class="col-md-8 form-group">
                                                    <select class="form-control" name="city" id="cities" required>
                                                        @foreach ($cities as $item)
                                                            <option value="{{$item->code}}" @if($data->city==$item->code)selected @endif> {{$item->name_city}} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-2"> <label>Quận/Huyện</label>(<span class="red">*</span>)</div>
                                                <div class="col-md-8 form-group">
                                                    <select class="form-control" name="province" id="provinces" required>
                                                        @foreach ($province as $item)
                                                            <option value="{{$item->name}}" @if($data->province==$item->name) selected @endif> {{$item->name}} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-2"><label>Phường/xã</label></div>
                                                <div class="col-md-8 form-group">
                                                    <input type="text" name="commune" class="form-control" value="{{$data->commune }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-2"><label>Đường/Địa chỉ </label></div>
                                                <div class="col-md-8 form-group">
                                                    <input type="text" name="street" class="form-control" value="{{$data->street}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-2"><label>Dự án</label></div>
                                                <div class="col-md-8 form-group">
                                                    <select name="project" class="form-control" id="project" style="height: 35px">
                                                        <option value="">--Chọn dự án--</option>
                                                        @foreach($project as $p_item)
                                                            <option value="{{$p_item->name}}" @if($data->project==$p_item->name) selected @endif>{{$p_item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-2"><label for="">Diện tích</label></div>
                                                <div class="col-md-8 form-group" style="display:flex">
                                                    <input type="text" style="width: 70%" name="acreage" class="form-control" value="{{number_format($data->acreage,0)}}"> <span style="padding-top: 10px;padding-left: 5px"> mét vuông</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-2"><label for="">Giá</label></div>
                                                <div class="col-md-8 form-group" style="display:flex">
                                                    <input type="text" style="width: 70%" name="price" class="form-control" value="{{$data->price}}"> <span style="padding-top: 10px;padding-left: 5px"> VNĐ</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-1"><label for="">Địa chỉ(<span class="red">*</span>)</label></div>
                                                <div class="col-md-10 form-group" >
                                                    <input required type="text"  name="address" class="form-control" value="{{$data->address}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            <div class="card-body row">
                                <div class="card card-default col-md-12">
                                    <div class="card-header header-min">
                                        <h3 class="card-title">Thông tin mô tả</h3>
                                    </div>
                                    <div class=" col-md-12">
                                        <div class="row">
                                            <div class="col-md-8 col-xs-12">
                                                <label for="">Tối đa 3000 kí tự(<span class="red">*</span>)</label>
                                                <div class=" form-group">
                                                    <textarea name="description" id="" style="width: 100%" class="form-control" rows="10">{{$data->description}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-xs-12">
                                                <label for="">Chú ý:</label>
                                                <p>
                                                    <i class="fa fa-caret-right" aria-hidden="true" style="color: blue"></i>
                                                    <span> Giới thiệu chung về bất động sản của bạn. Ví dụ: Khu nhà có vị trí thuận lợi: Gần công viên, gần trường học ... Tổng diện tích 52m2, đường đi ô tô vào tận cửa</span>
                                                </p>
                                                <p class="red">Lưu ý: tin rao chỉ để mệnh giá tiền Việt Nam Đồng.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body row" style="padding-bottom: 35px">
                                <div class="card card-default col-md-12">
                                    <div class="card-header header-min">
                                        <h3 class="card-title">Thông tin khác</h3>
                                    </div>
                                    <div class=" col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>Quý vị nên điền đầy đủ thông tin vào các mục dưới đây để tin đăng có hiệu quả hơn
                                                </p>
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-2"><label>Mặt tiền(m)</label></div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" name="facade" class="form-control" value="{{$data->facade}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-2"><label>Đường vào</label></div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" name="way_in" class="form-control" value="{{$data->way_in}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-2"><label>Hướng nhà</label></div>
                                                    <div class="col-md-8 form-group">
                                                        <select name="direction" id="" class="form-control">
                                                            <option value="KXĐ" @if($data->directio_balcony=='KXĐ') selected @endif>KXĐ</option>
                                                            <option value="Đông" @if($data->directio_balcony=='Đông') selected @endif>Đông</option>
                                                            <option value="Tây" @if($data->directio_balcony=='Tây') selected @endif>Tây</option>
                                                            <option value="Nam" @if($data->directio_balcony=='Nam') selected @endif>Nam</option>
                                                            <option value="Bắc" @if($data->directio_balcony=='Bắc') selected @endif>Bắc</option>
                                                            <option value="Đông-Bắc" @if($data->directio_balcony=='Đông-Bắc') selected @endif>Đông-Bắc</option>
                                                            <option value="Tây-Nam" @if($data->directio_balcony=='Tây-Nam') selected @endif>Tây-Nam</option>
                                                            <option value="Tây-Bắc" @if($data->directio_balcony=='Tây-Bắc') selected @endif>Tây-Bắc</option>
                                                            <option value="Đông-Nam" @if($data->directio_balcony=='Đông-Nam') selected @endif>Đông-Nam</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-2"><label>Hướng ban công</label></div>
                                                    <div class="col-md-8 form-group">
                                                        <select name="directio_balcony" id="" class="form-control">
                                                            <option value="KXĐ" @if($data->directio_balcony=='KXĐ')selected @endif>KXĐ</option>
                                                            <option value="Đông" @if($data->directio_balcony=='Đông') selected @endif>Đông</option>
                                                            <option value="Tây" @if($data->directio_balcony=='Tây') selected @endif>Tây</option>
                                                            <option value="Nam" @if($data->directio_balcony=='Nam') selected @endif>Nam</option>
                                                            <option value="Bắc" @if($data->directio_balcony=='Bắc') selected @endif>Bắc</option>
                                                            <option value="Đông-Bắc" @if($data->directio_balcony=='Đông-Bắc') selected @endif>Đông-Bắc</option>
                                                            <option value="Tây-Nam" @if($data->directio_balcony=='Tây-Nam') selected @endif>Tây-Nam</option>
                                                            <option value="Tây-Bắc" @if($data->directio_balcony=='Tây-Bắc') selected @endif>Tây-Bắc</option>
                                                            <option value="Đông-Nam" @if($data->directio_balcony=='Đông-Nam') selected @endif>Đông-Nam</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-2"><label>Số tầng</label></div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" name="floor" class="form-control" value="{{$data->floor}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-2"><label>Số phòng ngủ</label></div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" name="bedroom" class="form-control" value="{{$data->bedroom}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-2"><label>Số toilet</label></div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" name="toilet" class="form-control" value="{{$data->toilet}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-1"><label>Nội thất</label></div>
                                                    <div class="col-md-10 form-group">
                                                        <textarea name="furniture" id="" class="form-control" style="width: 100%" rows="10">{{$data->furniture}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body row" >
                                <div class="card card-default col-md-12">
                                    <div class="card-header header-min">
                                        <h3 class="card-title">Hình ảnh</h3>
                                    </div>
                                    <div class=" col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="">Ảnh nền</label>
                                                <input id="img" type="file" name="avatar"  class="form-control hidden" onchange="changeImg(this)" style="border: none">
                                                <img id="avatar"  class="imgPreview thumbnail" src="{{asset('/storage/avatar/'.$data->image)}}"/>
                                                <hr>
                                            </div>
                                            <div class="col-md-12 col-xs-12">
                                                <p>Tối đa 8 ảnh với tin thường và 16 với tin VIP. Mỗi ảnh tối đa 2MB</p>
                                                <p>Tin rao có ảnh sẽ được xem nhiều hơn gấp 10 lần và được nhiều người gọi gấp 5 lần so với tin rao không có ảnh. Hãy đăng ảnh để được giao dịch nhanh chóng!</p>
                                                <label for="">Thêm ảnh:</label>
                                                <input type="file" multiple name="images[]" id="file-input" >
                                                <div id="preview" ></div>
                                            </div>
                                            <div class="col-md-12" style="padding-top: 10px">
                                                <table id="example1" class="table table-bordered table-striped dataTable">
                                                    <tr style="text-align: center">
                                                        <th>Ảnh</th>
                                                        <th>xóa</th>
                                                    </tr>
                                                    @foreach($files as $file)
                                                        <tr>
                                                            <td><img src="@if(isset($file->img)){{asset('storage/avatar/'.$file->img)}} @endif" height="70" width="80" alt=""></td>
                                                            <td style="text-align: center"><a href="#" name="{{$file->img}}" link="{{ url($backendUrl.'/realestates/img/delete/'.$file->id) }}" class="deleteClick red id-btn-dialog2" data-toggle="modal" data-target="#deleteModal"> <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body row" >
                                <div class="card card-default col-md-12">
                                    <div class="card-header header-min">
                                        <h3 class="card-title">Liên hệ</h3>
                                    </div>
                                    <div class=" col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-1"><label>Tên liên hệ:</label></div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="text" name="name_contact" class="form-control" value="{{$data->name_contact}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-1"><label>Địa chỉ:</label></div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="text" name="address_contact" class="form-control" value="{{$data->address_contact}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12  col-xs-12" >
                                                    <div class="row">
                                                        <div class="col-md-1"><label>Di Động(<span class="red">*</span>)</label></div>
                                                        <div class="col-md-4 form-group">
                                                            <input required type="text" name="phone_contact" class="form-control" value="{{$data->phone_contact}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-xs-12" >
                                                    <div class="row">
                                                        <div class="col-md-1"><label>Email:</label></div>
                                                        <div class="col-md-4 form-group">
                                                            <input type="email" name="email_contact" class="form-control" value="{{$data->email_contact}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body row" >
                                <div class="card card-default col-md-12">
                                    <div class="card-header header-min">
                                        <h3 class="card-title">Lịch đăng tin</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Loại rao tin</label>
                                                    <select name="type_news" id="vip" class="form-control" style="height: 38px">
                                                        <option value="">Chọn gói vip</option>
                                                        @foreach($vip as $item)
                                                            <option value="{{$item->level}}">{{$item->name}} - Giá: {{$item->price}} VNĐ/{{$item->day}} Ngày</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 ">
                                                <div class="col-group">
                                                    <label for="">Ngày bắt đầu</label>
                                                    <input type="text"  name="start_date" id="start_date" required readonly value="{{$data->start_date}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4  ">
                                                @if($check==true)
                                                    <div class="col-group">
                                                        <label for="">Ngày kết thúc( Đã hết hạn)</label>
                                                        <span id="end_date"> <input type="text"  name="end_date" id="end_date"  readonly required value="{{$data->end_date}}" class="form-control"></span>
                                                        <span id=""> <input type="hidden"  name="" id="end"  readonly required value="{{$today}}" class="form-control"></span>

                                                    </div>
                                                @else
                                                    <div class="col-group">
                                                        <label for="">Ngày kết thúc</label>
                                                        <span id="end_date"> <input type="text"  name="end_date" id="end_date"  readonly required value="{{$data->end_date}} " class="form-control"></span>
                                                        <span id=""> <input type="hidden"  name="" id="end"  readonly required value="{{$data->end_date}}" class="form-control"></span>

                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-group">
                                                    {!! $paygates !!}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="card-body row" >
                            <div class="card card-default col-md-12">
                                <div class="card-header header-min">
                                    <h3 class="card-title">Chức năng</h3>
                                </div>
                                <div class=" col-md-12" style="padding-top: 10px">
                                    <div class="row">

                                        <div class="col-md-4 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-8 form-group">
                                                    <label for="status">Trạng thái</label>
                                                    @if($data->status==3)
                                                        <span>Đã hết hạn(vui lòng gia hạn)</span>
                                                    @else
                                                        <input name="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" @if( $data->status == 1 ) checked="checked" @endif>
                                                        <div class="Switch Round @if($data->status == 1) Off @else On @endif" style="vertical-align:top;margin-left:10px;">
                                                            <div class="Toggle"></div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4  col-xs-12" >
                                            <div class="row">
                                                <div class="col-md-8 form-group">
                                                    <label for="featured">Nổi bật</label>
                                                    <input name="featured" type="checkbox" value="featured" data-toggle="toggle" style="display: none;" @if( $data->featured == 1 ) checked="checked" @endif>
                                                    <div class="Switch Round @if($data->featured == 1) Off @else On @endif" style="vertical-align:top;margin-left:10px;">
                                                        <div class="Toggle"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4  col-xs-12" >
                                            <div class="row">
                                                <div class="col-md-8 form-group">
                                                    <label for="approved">Phê duyệt</label>
                                                    <input name="approved" type="checkbox" value="approved" data-toggle="toggle" style="display: none;" @if( $data->approved == 1 ) checked="checked" @endif>
                                                    <div class="Switch Round @if($data->approved == 1) Off @else On @endif" style="vertical-align:top;margin-left:10px;">
                                                        <div class="Toggle"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row" style="padding-left: 20px;padding-bottom: 10px">
                            <div class="card-footer" style="text-align: center; padding-top: 20px">
                                <button type="submit" class="btn btn-primary" style="padding: 10px 10px; font-size: 2rem">Cập nhật</button>
                                <a  href="{{route('realestates')}}" class="btn btn-danger" style="padding: 10px 10px; font-size: 2rem ">Hủy</a>
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
        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".deleteClick").click(function(){
                var link = $(this).attr('link');
                var name = $(this).attr('name');
                $("#deleteForm").attr('action',link);
                $("#deleteMes").html("Delete : "+name+" ?");
            });
        });
    </script>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="deleteForm" action="" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="deleteMes" class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <input type="hidden" name="_method" value="delete" />
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
    <!-- End Delete form-->

@endsection
