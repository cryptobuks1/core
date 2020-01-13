@extends('frontend.'.$current_theme.'.app')
@section('title')

@section('customstyle')

    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/myadmin.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


@endsection

@section('content')
    <!-- Main content -->
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
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="col-md-12">
                    <!-- general form elements -->
                    @include('layouts.errors')
                    <div class=" card-default">
                        <div class="card-header ">
                            <h2 class="" style="font-weight: 700; font-size: 25px; text-align: center; color: #0b6998">SỬA TIN RAO</h2>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {!! Form::model($data, ['method' => 'PATCH','route' => ['tin.update', $data->id],'enctype'=>'multipart/form-data']) !!}
                            <div class="card-body row">
                                <div class=" card-default col-md-12">
                                    <div class="card-header header-min">
                                        <h3 class="card-title">Thông tin cơ bản</h3>
                                    </div>
                                    <div class="col-md-12" style="padding-top: 15px">
                                        <div class=" row">
                                            <div class="col-md-12 col-xs-12">
                                                <div class="row" >
                                                    <div class="col-md-2"><label for="">Tiêu đề(<span class="red">*</span>)</label></div>
                                                    <div class="col-md-12 form-group" >
                                                        <input required type="text"  name="title" class="form-control" value="{{$data->title}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3"><label>Hình thức</label>(<span class="red">*</span>)</div>
                                                    <div class="col-md-9 form-group">
                                                        <select name="form" class="form-control" id="form" style="height: 35px">
                                                            <option value="1" @if($data->form==1)selected @endif>Nhà đất bán</option>
                                                            <option value="2" @if($data->form==2)selected @endif>Nhà đất cho thuê</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3"> <label>Loại</label> (<span class="red">*</span>)</div>
                                                    <div class="col-md-9 form-group">
                                                        <select name="type" class="form-control" id="type" style="height: 35px">
                                                            @foreach ($types as $item)
                                                                <option value="{{$item->name}}" @if($data->type==$item->name)selected @endif> {{$item->name}} </option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <div class="row ">
                                                    <div class="col-md-3"><label>Tỉnh/Thành</label>(<span class="red">*</span>)</div>
                                                    <div class="col-md-9 form-group">
                                                        <select class="form-control" name="city" id="cities" style="height: 35px" required>
                                                            @foreach ($cities as $item)
                                                                <option value="{{$item->code}}" @if($data->city==$item->code)selected @endif> {{$item->name_city}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3"> <label>Quận/Huyện</label>(<span class="red">*</span>)</div>
                                                    <div class="col-md-9 form-group">
                                                        <select class="form-control" name="province" id="provinces" style="height: 35px" required>
                                                            @foreach ($province as $item)
                                                                <option value="{{$item->name}}" @if($data->province==$item->name) selected @endif> {{$item->name}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3"><label>Phường/xã</label></div>
                                                    <div class="col-md-9 form-group">
                                                        <input type="text" name="commune" class="form-control" value="{{$data->commune }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3"><label>Đường/Địa chỉ </label></div>
                                                    <div class="col-md-9 form-group">
                                                        <input type="text" name="street" class="form-control" value="{{$data->street}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3"><label>Dự án</label></div>
                                                    <div class="col-md-9 form-group">
                                                        <select name="project" class="form-control" id="project" style="height: 35px">
                                                            @foreach($project as $p_item)
                                                                <option value="{{$p_item->name}}" @if($data->project==$p_item->name) selected @endif>{{$p_item->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3"><label for="">Diện tích</label></div>
                                                    <div class="col-md-9 form-group" style="display:flex">
                                                        <input type="text" style="width: 70%" name="acreage" class="form-control" value="{{number_format($data->acreage,0)}}"> <span style="padding-top: 10px;padding-left: 5px"> mét vuông</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-3"><label for="">Giá</label></div>
                                                    <div class="col-md-9 form-group" style="display:flex">
                                                        <input type="text" style="width: 70%" name="price" class="form-control" value="{{$data->price}}"> <span style="padding-top: 10px;padding-left: 5px"> VNĐ</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-xs-12">
                                                <div class="row">
                                                    <div class="col-md-2"><label for="">Địa chỉ(<span class="red">*</span>)</label></div>
                                                    <div class="col-md-12 form-group" >
                                                        <input required type="text"  name="address" class="form-control" value="{{$data->address}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body row">
                                    <div class=" card-default col-md-12">
                                        <div class="card-header header-min">
                                            <h3 class="card-title">Thông tin mô tả</h3>
                                        </div>
                                        <div class=" col-md-12" style="padding-top: 15px">
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

                                <div class="card-body row">
                                    <div class=" card-default col-md-12">
                                        <div class="card-header header-min">
                                            <h3 class="card-title">Thông tin khác</h3>
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
                                                            <input type="text" name="facade" class="form-control" value="{{$data->facade}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-3"><label>Đường vào</label></div>
                                                        <div class="col-md-9 form-group">
                                                            <input type="text" name="way_in" class="form-control" value="{{$data->way_in}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-3"><label>Hướng nhà</label></div>
                                                        <div class="col-md-9 form-group">
                                                            <select name="direction" id="" class="form-control" style="height: 35px">
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
                                                        <div class="col-md-3"><label>Hướng ban công</label></div>
                                                        <div class="col-md-9 form-group">
                                                            <select name="directio_balcony" id="" class="form-control" style="height: 35px">
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
                                                        <div class="col-md-3"><label>Số tầng</label></div>
                                                        <div class="col-md-9 form-group">
                                                            <input type="text" name="floor" class="form-control" value="{{$data->floor}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-3"><label>Số phòng ngủ</label></div>
                                                        <div class="col-md-9 form-group">
                                                            <input type="text" name="bedroom" class="form-control" value="{{$data->bedroom}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-3"><label>Số toilet</label></div>
                                                        <div class="col-md-9 form-group">
                                                            <input type="text" name="toilet" class="form-control" value="{{$data->toilet}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="row">
                                                        <div class="col-md-2"><label>Nội thất</label></div>
                                                        <div class="col-md-12 form-group">
                                                            <textarea name="furniture" id="" class="form-control" style="width: 100%" rows="10">{{$data->furniture}}</textarea>
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
                                            <h3 class="card-title">Hình ảnh</h3>
                                        </div>
                                        <div class=" col-md-12" style="padding-top: 15px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="">Ảnh nền(<span class="red">*</span>)</label>

                                                    <input id="img" type="file" name="avatar" class="form-control hidden" onchange="changeImg(this)" style="border: none">
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
                                                                <td style="text-align: center"><a href="{{asset('/realestates/img/delete/'.$file->id)}}" name="{{$file->img}}"  class=" red id-btn-dialog2" > <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body row">
                                    <div class=" card-default col-md-12">
                                        <div class="card-header header-min">
                                            <h3 class="card-title">Liên hệ</h3>
                                        </div>
                                        <div class=" col-md-12" style="padding-top: 15px">
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-md-2"><label>Tên liên hệ:</label></div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="text" name="name_contact" class="form-control" value="{{$data->name_contact}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-md-2"><label>Địa chỉ:</label></div>
                                                            <div class="col-md-8 form-group">
                                                                <input type="text" name="address_contact" class="form-control" value="{{$data->address_contact}}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12  col-xs-12" >
                                                        <div class="row">
                                                            <div class="col-md-2"><label>Di Động(<span class="red">*</span>)</label></div>
                                                            <div class="col-md-4 form-group">
                                                                <input required type="text" name="phone_contact" class="form-control" value="{{$data->phone_contact}}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 col-xs-12" >
                                                        <div class="row">
                                                            <div class="col-md-2"><label>Email:</label></div>
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

                                <div class="card-body row">
                                    <div class=" card-default col-md-12">
                                        <div class="card-header header-min">
                                            <h3 class="card-title">Trạng thái</h3>
                                        </div>
                                        <div class=" col-md-12" style="padding-top: 15px">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Trạng thái:</label>
                                                        <select name="status" id="" class="form-control" style="height: 35px">
                                                            @if($data->status==3)
                                                            <option value="3">  Đã hết hạn (Vui lòng gia hạn tin)</option>
                                                            @else
                                                            <option value="1"@if($data->status==1) selected @endif>Bật</option>
                                                            <option value="0"@if($data->status==0) selected @endif>Tắt</option>
                                                            @endif
                                                        </select>
                                                        @if($data->status==3)
                                                        <div style="padding-top: 10px">
                                                            <a href="{{ asset('realestates/vip/'.$data->id.'/'.$data->slug)}}" class="btn btn-primary">Gia hạn tin tại đây</a>
                                                        </div>
                                                        @endif
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
                            {!! Form::close() !!}
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>



    </section>
    <!-- /.content -->
@endsection

@section('js-footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
                $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.time') }}',
                    data: { vip: vip},
                    success: function (data) {
                        $('#end').html(data);
                    }
                });
            }));
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

    </script>

    <script >
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

