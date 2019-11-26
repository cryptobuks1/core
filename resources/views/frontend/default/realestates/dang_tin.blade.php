@extends('frontend.'.$current_theme.'.app')
@section('title')

@section('customstyle')

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <style>
        table td{
            font-size: 15px;
        }
        .red{
            color: red;
        }
        .blue{
            color: #00c0ef;
        }
        .header-min h3{
            font-size: 20px;
            color: #00c0ef;
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

@section('content')
    <!-- Main content -->

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="col-md-12">
                    <!-- general form elements -->
                    @include('layouts.errors')
                    <div class=" card-default">
                        <div class="card-header ">
                            <h2 class="" style="font-weight: 700; font-size: 25px; text-align: center; color: #0b6998">ĐĂNG TIN RAO</h2>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form  method="post" enctype='multipart/form-data'>
                            <div class="card-body row">
                                <div class=" card-default col-md-12" >
                                    <div class="card-header header-min">
                                        <h3 class="">Thông tin cơ bản</h3>
                                    </div>
                                    <div class="col-md-12" style="padding-top: 15px">
                                        <div class="form-group row">
                                            <div class="col-md-12 col-xs-12">
                                                <div class="row" >
                                                    <div class="col-md-2"><label for="">Tiêu đề(<span class="red">*</span>)</label></div>
                                                    <div class="col-md-12 form-group" >
                                                        <input required type="text"  name="title" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3"><label>Hình thức</label>(<span class="red">*</span>)</div>
                                                    <div class="col-md-9 form-group">
                                                        <select name="form" class="form-control " style="height: 35px;" id="form" required>
                                                            <option value="" style="text-align: center">-- Chọn hình thức --</option>
                                                            <option value="1">Nhà đất bán</option>
                                                            <option value="2">Nhà đất cho thuê</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3"> <label>Loại</label> (<span class="red">*</span>)</div>
                                                    <div class="col-md-9 form-group">
                                                        <select name="type" class="form-control" id="type"  style="height: 35px;" required >
                                                            <option style="text-align: center" >-- Phân mục --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3"><label>Tỉnh/Thành</label>(<span class="red">*</span>)</div>
                                                    <div class="col-md-9 form-group">
                                                        <select class="form-control" name="city" id="cities" required style="height: 35px;">
                                                            <option value="" >-- Chọn tỉnh/thành phố --</option>
                                                            @foreach ($cities as $news)
                                                                <option value="{{$news->code}}"> {{$news->name_city}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3"> <label>Quận/huyện</label>(<span class="red">*</span>)</div>
                                                    <div class="col-md-9 form-group">
                                                        <select class="form-control" name="province" id="provinces" style="height: 35px;" required>
                                                            <option value="">-- Chọn quận\huyện --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3"><label>Phường/xã</label></div>
                                                    <div class="col-md-9 form-group"  >
                                                        <input type="text" name="commune" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3"><label>Đường/Địa chỉ </label></div>
                                                    <div class="col-md-9 form-group">
                                                        <input type="text" name="street" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3"><label>Dự án</label></div>
                                                    <div class="col-md-9 form-group">
                                                        <select name="project" class="form-control" id="project"  style="height: 35px">
                                                            <option value="">-- Chọn dự án --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3"><label for="">Diện tích</label></div>
                                                    <div class="col-md-9 form-group" style="display:flex">
                                                        <input type="text" style="width: 70%" name="acreage" class="form-control"> <span style="padding-top: 10px;padding-left: 5px"> mét vuông</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3"><label for="">Giá</label></div>
                                                    <div class="col-md-9 form-group" style="display:flex">
                                                        <input type="text" style="width: 70%" name="price" id="price" class="form-control"> <span style="padding-top: 10px;padding-left: 5px"> VNĐ</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-2"><label for="">Địa chỉ(<span class="red">*</span>)</label></div>
                                                    <div class="col-md-12 form-group" >
                                                        <input required type="text"  name="address" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                <div class="card-body row">
                                    <div class=" card-default col-md-12">
                                        <div class="card-header header-min">
                                            <h3 class="">Thông tin mô tả</h3>
                                        </div>
                                        <div class=" col-md-12" style="padding-top: 15px">
                                            <div class="row">
                                                <div class="col-md-8 col-xs-12">
                                                    <label for="">Tối đa 3000 kí tự(<span class="red">*</span>)</label>

                                                    <div class=" form-group">
                                                        <textarea name="description" id="" style="width: 100%" class="form-control" rows="10" required></textarea>
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

                                <div class="card-body row">
                                    <div class=" card-default col-md-12">
                                        <div class="card-header header-min">
                                            <h3 class="">Thông tin khác</h3>
                                        </div>
                                        <div class=" col-md-12" style="padding-top: 15px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p>Quý vị nên điền đầy đủ thông tin vào các mục dưới đây để tin đăng có hiệu quả hơn
                                                    </p>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-3"><label>Mặt tiền(m)</label></div>
                                                        <div class="col-md-9 form-group">
                                                            <input type="text" name="facade" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-3"><label>Đường vào</label></div>
                                                        <div class="col-md-9 form-group">
                                                            <input type="text" name="way_in" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-3"><label>Hướng nhà</label></div>
                                                        <div class="col-md-9 form-group">
                                                            <select name="direction" id="" class="form-control" style="height: 35px;">
                                                                <option value="KXĐ">KXĐ</option>
                                                                <option value="Đông">Đông</option>
                                                                <option value="Tây">Tây</option>
                                                                <option value="Nam">Nam</option>
                                                                <option value="Bắc">Bắc</option>
                                                                <option value="Đông-Bắc">Đông-Bắc</option>
                                                                <option value="Tây-Nam">Tây-Nam</option>
                                                                <option value="Tây-Bắc">Tây-Bắc</option>
                                                                <option value="Đông-Nam">Đông-Nam</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-3"><label>Hướng ban công</label></div>
                                                        <div class="col-md-9 form-group">
                                                            <select name="directio_balcony" id="" class="form-control" style="height: 35px;">
                                                                <option value="KXĐ">KXĐ</option>
                                                                <option value="Đông">Đông</option>
                                                                <option value="Tây">Tây</option>
                                                                <option value="Nam">Nam</option>
                                                                <option value="Bắc">Bắc</option>
                                                                <option value="Đông-Bắc">Đông-Bắc</option>
                                                                <option value="Tây-Nam">Tây-Nam</option>
                                                                <option value="Tây-Bắc">Tây-Bắc</option>
                                                                <option value="Đông-Nam">Đông-Nam</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-3"><label>Số tầng</label></div>
                                                        <div class="col-md-9 form-group">
                                                            <input type="text" name="floor" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-3"><label>Số phòng ngủ</label></div>
                                                        <div class="col-md-9 form-group">
                                                            <input type="text" name="bedroom" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-3"><label>Số toilet</label></div>
                                                        <div class="col-md-9 form-group">
                                                            <input type="text" name="toilet" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-2"><label>Nội thất</label></div>
                                                        <div class="col-md-12 form-group">
                                                            <textarea name="furniture" id="" class="form-control" style="width: 100%" rows="10"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body row">
                                    <div class=" card-default col-md-12">
                                        <div class="card-header header-min">
                                            <h3 class="">Hình ảnh</h3>
                                        </div>
                                        <div class=" col-md-12">
                                            <div class="row">
                                                <div class="col-md-12" style="padding-top: 15px">
                                                    <label for="">Ảnh nền(<spann class="red">*</spann>)</label>
                                                    <input required id="img" type="file" name="avatar"  onchange="changeImg(this)">
                                                    <img id="avatar" class="thumbnail" width="200px" src="">
                                                    <hr>
                                                </div>
                                                <div class="col-md-12 col-xs-12">
                                                    <p>Tối đa 8 ảnh với tin thường và 16 với tin VIP. Mỗi ảnh tối đa 2MB</p>
                                                    <p>Tin rao có ảnh sẽ được xem nhiều hơn gấp 10 lần và được nhiều người gọi gấp 5 lần so với tin rao không có ảnh. Hãy đăng ảnh để được giao dịch nhanh chóng!</p>
                                                    <input type="file" multiple name="images[]" id="file-input" >
                                                    <div id="preview" ></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body row">
                                    <div class=" card-default col-md-12">
                                        <div class="card-header header-min">
                                            <h3 class="">Liên hệ</h3>
                                        </div>
                                        <div class=" col-md-12" style="padding-top: 15px">
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-md-2"><label>Tên liên hệ:</label></div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="text" name="name_contact" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-md-2"><label>Địa chỉ:</label></div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="text" name="address_contact" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12  col-xs-12" >
                                                        <div class="row">
                                                            <div class="col-md-2"><label>Di Động(<span class="red">*</span>)</label></div>
                                                            <div class="col-md-4 form-group">
                                                                <input required type="text" name="phone_contact" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-xs-12" >
                                                        <div class="row">
                                                            <div class="col-md-2"><label>Email:</label></div>
                                                            <div class="col-md-4 form-group">
                                                                <input type="email" name="email_contact" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body row" >
                                    <div class=" card-default col-md-12">
                                        <div class="card-header nav nav-tabs" >
                                            <ul class="nav nav-tabs"  >
                                                <li class="active"><a data-toggle="tab" id="free" href="#home" style="color: black; background-color: #00c0ef">Đăng tin miễn phí</a></li>
                                                <li><a data-toggle="tab" href="#menu1" id="mat-phi" style="color: black; background-color: #00c0ef">Đăng mất phí</a></li>
                                            </ul>
                                        </div>
                                        <div class="tab-content" style="padding-top: 15px">
                                        <div class=" col-md-12 tab-pane fade in active" id="home">
                                            <div class="row">

                                                <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        <label for="">Ngày bắt đầu</label>
                                                        <input type="text"  name="start_date"  required readonly value="{{$date}}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4  ">
                                                    <div class="form-group">
                                                        <label for="">Ngày kết thúc</label>
                                                        <span > <input type="text"  name="end_date"   readonly required value="{{$end_day}}" class="form-control"></span>
                                                    </div>
                                                </div>
                                                <div style="display: flex; padding-left: 5px" class="col-md-12">
                                                    <label for="">Tin thường: </label><p>Tin thường bạn chỉ đăng được 7 ngày</p>
                                                </div>
                                                <div style="display: block" class="col-md-12">
                                                    <p> <i class="fa fa-arrow-circle-right" aria-hidden="true" style="padding-right: 5px; color: gold"></i>
                                                        Quý khách nên chọn đăng tin Vip để có hiệu quả cao hơn và vip càng cao thì giá càng rẻ, ví dụ: tin Vip1 có lượt xem trung bình cao hơn 20 lần so với tin thường
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" col-md-12 tab-pane fade" id="menu1">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Loại rao tin</label>
                                                        <select name="type_news" id="vip" class="form-control" style="color:#00bb00; font-weight: 700; height: 35px">
                                                            <option value="7">Chọn gói vip</option>
                                                            @foreach($vip as $item)
                                                                <option  value="{{$item->level}}" data-key="{{$item->price}}">{{$item->name}}   -    Giá:{{$item->price}} VNĐ/{{$item->day}} Ngày</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        <label for="">Ngày bắt đầu</label>
                                                        <input type="text"  name="start_date" id="start" required readonly value="{{$date}}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-4  ">
                                                    <div class="form-group">
                                                        <label for="">Ngày kết thúc</label>
                                                        <span id="end"> <input type="text"  name="end_date" id="end"  readonly required value="{{$end_day}}" class="form-control"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="col-group">
                                                        {!! $paygates !!}
                                                    </div>
                                                </div>
                                                <div style="display: flex; padding-left: 5px" class="col-md-12">
                                                    <label for="">Tin thường: </label><p>Là loại tin đăng bằng chữ <span class="blue">màu xanh</span>, khung <span class="blue">màu xanh</span></p>
                                                </div>
                                                <div style="display: block" class="col-md-12">
                                                    <p> <i class="fa fa-arrow-circle-right" aria-hidden="true" style="padding-right: 5px; color: gold"></i>
                                                        Quý khách nên chọn đăng tin Vip để có hiệu quả cao hơn và vip càng cao thì giá càng rẻ, ví dụ: tin Vip1 có lượt xem trung bình cao hơn 20 lần so với tin thường
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                            <div class="row" style="padding-left: 20px;padding-bottom: 10px">
                                <div class="card-footer" style="text-align: center; padding-top: 20px">
                                    <button type="submit" class="btn btn-primary" style="padding: 10px 10px; font-size: 2rem">Đăng tin</button>
                                    <a  href="{{route('tin.rao')}}" class="btn btn-danger" style="padding: 10px 10px; font-size: 2rem ">Hủy</a>
                                </div>
                            </div>
                            @csrf
                        </form>
                        {{--                        {!! Form::close() !!}--}}
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection


@section('js-footer')
    <script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-de7e2ef6bfefd24b79a3f68b414b87b8db5b08439cac3f1012092b2290c719cd.js"></script>
    <script src="https://rawgit.com/vuejs/vue/master/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
            $(document).ready(function() {
                $("#cities").on('change', (function(e){
                    var city_code = $(this).val();
                    console.log(city_code);
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

        });
        $(document).ready(function() {
            $("#vip").on('change', (function (e) {
                var vip = $('#vip').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.time2') }}',
                    data: { vip: vip},
                    success: function (data) {
                        $('#end').html(data);

                    }
                });
            }));
            $('#free').on('click',function () {
                $("#vip").val("7");
            });
        });
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


