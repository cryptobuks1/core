@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}"
          xmlns="http://www.w3.org/1999/html">
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
    <script>
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
    </script>
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
    <script>
        function addNewImage() {
            let htmlImage = document.getElementById('html-image');
            let inputImage = document.createElement("input");

            inputImage.setAttribute('type', 'file');
            inputImage.setAttribute('name', 'filename[]');
            inputImage.setAttribute('multiple', '');
            htmlImage.appendChild(inputImage);
            inputImage.style.marginBottom = "20px";

        }
    </script>

    <script>

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
    </script>

@endsection

@section('content')
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
    </style>
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
                        <form  method="post" enctype='multipart/form-data'>
                        <div class="card-body row">
                            <div class="card card-default col-md-12">
                                <div class="card-header header-min">
                                    <h3 class="card-title">Thông tin cơ bản</h3>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group row">
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
                                                        <option value="0" @if($data->form==0)selected @endif>Nhà đất bán</option>
                                                        <option value="1" @if($data->form==1)selected @endif>Nhà đất cho thuê</option>
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
                                                <div class="col-md-2"><label>City</label>(<span class="red">*</span>)</div>
                                                <div class="col-md-8 form-group">
                                                    <select class="form-control" name="city" id="cities">
                                                        @foreach ($cities as $item)
                                                            <option value="{{$item->code}}" @if($data->city==$item->code)selected @endif> {{$item->name_city}} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-2"> <label>Province</label>(<span class="red">*</span>)</div>
                                                <div class="col-md-8 form-group">
                                                    <select class="form-control" name="province" id="provinces">
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
                                                    <input type="text" name="project" class="form-control" value="{{$data->project}}">
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
                                    <div class="form-control col-md-12">
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
                                    <div class="form-control col-md-12">
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


                            <div class="card-body row" style="padding-bottom: 35px">
                                <div class="card card-default col-md-12">
                                    <div class="card-header header-min">
                                        <h3 class="card-title">Hình ảnh</h3>
                                    </div>
                                    <div class="form-control col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="">Ảnh nền</label>
                                                <input type="file" name="avatar">
                                                <hr>
                                            </div>
                                            <div class="col-md-12 col-xs-12">
                                                <p>Tối đa 8 ảnh với tin thường và 16 với tin VIP. Mỗi ảnh tối đa 2MB</p>
                                                <p>Tin rao có ảnh sẽ được xem nhiều hơn gấp 10 lần và được nhiều người gọi gấp 5 lần so với tin rao không có ảnh. Hãy đăng ảnh để được giao dịch nhanh chóng!</p>
                                                <input type="file" multiple="multiple" name="images[]">
                                            </div>
                                            <div class="col-md-12" style="padding-top: 10px">
                                                <table id="example1" class="table table-bordered table-striped dataTable">
                                                    <tr style="text-align: center">
                                                        <th>Ảnh</th>
                                                        <th>xóa</th>
                                                    </tr>
                                                    @foreach($files as $file)
                                                        <tr>
                                                            <td>{{$file->img}}</td>
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


                            <div class="card-body row" style="padding-bottom: 35px">
                                <div class="card card-default col-md-12">
                                    <div class="card-header header-min">
                                        <h3 class="card-title">Liên hệ</h3>
                                    </div>
                                    <div class="form-control col-md-12">
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



                            <div class="card-body row" style="padding-bottom: 35px">
                                <div class="card card-default col-md-12">
                                    <div class="card-header header-min">
                                        <h3 class="card-title">Lịch đăng tin</h3>
                                    </div>
                                    <div class="form-control col-md-12">
                                        <div class="row">
                                            <div class="col-md-3 pull-right-md-1">
                                                <div class="form-group">
                                                    <label for="">Loại rao tin</label>
                                                    <select name="type_news" id="" class="form-control">
                                                        <option value="5" @if($data->type_news==5)selected @endif>Tin Thường</option>
                                                        <option value="4" @if($data->type_news==4)selected @endif>Tin Ưu Đãi</option>
                                                        <option value="3" @if($data->type_news==3)selected @endif>Tin Vip 3</option>
                                                        <option value="2" @if($data->type_news==2)selected @endif>Tin Vip 2</option>
                                                        <option value="1" @if($data->type_news==1)selected @endif>Tin Vip 1</option>
                                                        <option value="0" @if($data->type_news==0)selected @endif>Tin Vip Đặc Biệt</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 offset-md-1">
                                                <div class="col-group">
                                                    <label for="">Ngày bắt đầu</label>
                                                    <input type="date" class="form-control" name="start_date" value="{{$data->start_date}}" >
                                                </div>
                                            </div>

                                            <div class="col-md-3 offset-md-1 ">
                                                <div class="col-group">
                                                    <label for="">Ngày kết thúc</label>
                                                    <input type="date" class="form-control" name="end_date" value="{{$data->end_date}}">
                                                </div>
                                            </div>
                                            <div style="display: flex; padding-left: 5px" class="cool-md-12">
                                                <label for="">Tin thường: </label><p>Là loại tin đăng bằng chữ <span class="blue">màu xanh</span>, khung <span class="blue">màu xanh</span></p>
                                            </div>
                                            <div style="display: block" class="col-md-12">
                                                <p> <i class="fa fa-arrow-circle-right" aria-hidden="true" style="padding-right: 5px; color: gold"></i>
                                                    Quý khách nên chọn đăng tin Vip để có hiệu quả cao hơn, ví dụ: tin Vip1 có lượt xem trung bình cao hơn 20 lần so với tin thường
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        <div class="card-body row" style="padding-bottom: 30px">
                            <div class="card card-default col-md-12">
                                <div class="card-header header-min">
                                    <h3 class="card-title">Chức năng</h3>
                                </div>
                                <div class="form-control col-md-12">
                                    <div class="row">

                                        <div class="col-md-4 col-xs-12">
                                            <div class="row">

                                                <div class="col-md-8 form-group">
                                                    <label>Trạng thái:</label>
                                                    <select name="status" id="" class="form-control">
                                                        <option value="0" @if($data->status==0) selected @endif>Tắt</option>
                                                        <option value="1" @if($data->status==1) selected @endif>Bật</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <div class="row">

                                                <div class="col-md-8 form-group">
                                                    <label>Nổi bật:</label>
                                                    <select name="featured" id="" class="form-control">
                                                        <option value="0" @if($data->featured==0) selected @endif>Không nổi bật</option>
                                                        <option value="1" @if($data->featured==1) selected @endif>Nổi bật</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4  col-xs-12" >
                                            <div class="row">
                                                <div class="col-md-8 form-group">
                                                    <label>Phê duyệt:</label>
                                                    <select name="approved" id="" class="form-control">
                                                        <option value="0" @if($data->approved==0) selected @endif>Chưa phê duyệt</option>
                                                        <option value="1" @if($data->approved==1) selected @endif>Phê Duyệt</option>
                                                    </select>
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
                                <a  href="{{route('tin.rao')}}" class="btn btn-danger" style="padding: 10px 10px; font-size: 2rem ">Hủy</a>
                            </div>
                        </div>
                        @csrf
                                </form>
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
