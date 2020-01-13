@extends('frontend.'.$current_theme.'.app')
@section('title')
@section('customstyle')
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/myadmin.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/trix/1.2.0/trix.css">


    <style>
        #main-create-broker .content-wap{
            border: 1px solid #ccc;
            background: #fff none repeat scroll 0 0;
        }
        .broker-top h2{
            text-align: center;
            color: #00c0ef;
            text-transform: uppercase;
            padding-bottom: 20px;
        }
        .lb-broker{
            color: #00c0ef;
        }
        .content-wap {
            padding: 15px;
        }
        .red{
            color: red;
        }
        .form-group select, .form-group  input{
            height: 39px;
        }
    </style>

@endsection

@section('content')

    <div class="create-broker">
        <div class="broker-top">
            <h2>Thêm Nhà Môi Giới</h2>
        </div>
        <div id="main-create-broker" class="container">
            <div class="content-wap">
                @include('layouts.errors')
                <form action="{{route('broker.create')}}" method="POST" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="name" class="lb-broker">Tên môi giới(<span class="red">*</span>):</label>
                                <input type="text" name="name" placeholder="Nhập tên công ty mô giới" required class="form-control" value="{{old('name')}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type" class="lb-broker">Loại môi giới(<span class="red">*</span>):</label>
                                <select name="type" id="" class="form-control">
                                    <option value="1">Cá nhân môi giới</option>
                                    <option value="2">Công ty môi giới</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image" class="lb-broker">Ảnh đại diện(<span class="red">*</span>):</label>
                                <input required id="img" type="file" name="image"  onchange="changeImg(this)">
                                <img id="avatar" class="thumbnail" width="200px" src="">
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="form-group">
                                <label for="city" class="lb-broker">Tỉnh/Thành</label>(<span class="red">*</span>)
                                <select class="form-control" name="city" id="cities" required >
                                    <option value="" >-- Chọn tỉnh/thành phố --</option>
                                    @foreach ($cities as $news)
                                        <option value="{{$news->code}}"> {{$news->name_city}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class=" form-group">
                                <label for="province" class="lb-broker">Quận/huyện</label>(<span class="red">*</span>)
                                <select class="form-control" name="province" id="provinces"  required>
                                    <option value="">-- Chọn quận/huyện --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address" class="lb-broker">Địa chỉ(<span class="red">*</span>):</label>
                                <input type="text" name="address" placeholder="Nhập địa chỉ công ty" required class="form-control" value="{{old('address')}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="lb-broker">Số điện thoại(<span class="red">*</span>):</label>
                                <input type="text" name="phone" placeholder="Nhập số điện thoại công ty" required class="form-control" value="{{old('phone')}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="lb-broker">Email(<span class="red">*</span>):</label>
                                <input type="email" name="email" placeholder="Nhập email công ty" required class="form-control" value="{{old('email')}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="website" class="lb-broker">Website:</label>
                                <input type="url" name="website" placeholder="Nhập website công ty" class="form-control" value="{{old('website')}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="website" class="lb-broker">Trạng thái:</label>
                                <select name="status" id="" class="form-control">
                                    <option value="1">Bật</option>
                                    <option value="0">Tắt</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fields" class="lb-broker">Chọn các lĩnh vực(<span class="red">*</span>):</label>
                                <select name="fields[]" id="" class="form-control" required multiple style="height: 150px">
                                    @foreach($types as $type)
                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="introduce" class="lb-broker">Giới thiệu về công ty:</label>
                                <textarea name="introduce" id="" cols="30" rows="10" class="form-control">{{ old('introduce')}}</textarea>
                            </div>
                        </div>
                    </div>
                    <textarea class="test hidden" name="introduce_show">
                    </textarea>
                    <div>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                        <a href="{{route('tin.rao')}}" class="btn btn-warning">Hủy</a>
                    </div>
                    @csrf
                </form>
{{--                hết form--}}
            </div>
{{--            hết content-wap--}}
        </div>
{{--        hết main-create-broker--}}
    </div>
{{--    hêt create_broker--}}

@endsection

@section('js-footer')
    <script src="https://cdn.bootcss.com/trix/1.2.0/trix-core.js"></script>
    <script >
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

        $(window).load(function() {
            var introduce = $('#introduce').val();
            var txttostore = '<p>' + introduce.replace(/\n/g, "</p>\n<p>") + '</p>';
            $('.test').val(txttostore);

        });
    </script>
@endsection
