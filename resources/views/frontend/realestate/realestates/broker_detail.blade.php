@extends('frontend.'.$current_theme.'.app')
@section('title')
@section('customstyle')
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/myadmin.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    <style>
        #main-broker .content-wap{
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
        .content-wap .tab-content #menu1, .content-wap .tab-content #menu2{
            border: 1px solid #ccc;
            margin: 15px;
        }
        .item-broker{
            padding: 15px;
        }
        .item-broker h4{
            margin-top: 0 !important;
        }
        a:hover{
            text-decoration: none;
        }
        .form-group #search {
            float: right;
            top: 10px;
        }
        .search .form-group{
            display: flex;
        }
        .binh-thuong{
            font-weight: 700; color: gray; font-size: 15px;
        }
        .noi-bat{
            font-weight: 700; color: orangered; font-size: 15px;
        }
    </style>

@endsection

@section('content')
    <div class="create-broker">
        <div id="main-broker" class="container">
            <div class="content-wap">
                @include('layouts.errors')
                <div class="row">
                    @include('frontend.realestate.realestates.search_broker')
                    <div class="col-md-12" >
                        <hr>
                        <div class="broker-top">
                            <h2>{{$broker->name}}</h2>
                        </div>
                        @if($broker)
                            <div class="item-broker">
                                <div class="row">
                                    <div class="col-md-4" style="padding-bottom: 10px">
                                        <img src="{{asset('/storage/avatar/'.$broker->image)}}" alt="" style="width: 100%" >
                                    </div>
                                    <div class="col-md-8">
                                        <h4 >CÔNG TY: {{$broker->name}}</h4>
                                        <p><label for="">Địa chỉ:</label> {{$broker->address}}</p>
                                        <p><label for="">Số điện thoại</label>: {{$broker->phone}}</p>
                                        <p><label for="">Email</label>: {{$broker->email}}</p>
                                        @if($broker->website)
                                            <p><label for="">Website:</label> <a href="{{$broker->website}}">{{$broker->website}}</a></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                                <p style="text-align: center; font-size: 15px; color: #00c0ef">Không có nhà môi giới nào</p>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <div class="type">
                            <h3>Lĩnh vực môi giới</h3>
                                @foreach($broker->fields as $item)
                                    @foreach($types as $type)
                                        @if($item==$type->id)
                                            <p><strong>- {{$type->name}}</strong></p>
                                        @endif
                                    @endforeach
                                @endforeach
                            <hr>
                        </div>
                        <div class="introduce">
                            <h3>Giới thiệu</h3>
                            {!! $broker->introduce_show !!}
                        </div>
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <div class="list-tin-rao">
                            <h3>Danh sách tin rao</h3>
                            <div class="ds-tin-rao">
                                @if(count($data)>0)
                                @foreach($data as $item)
                                    <div class="item">
                                        <div class="row">
                                            <div class="item-tin-rao" style="padding: 5px 5px">
                                                <div class="col-md-4">
                                                    <a href="{{asset('realestates/tin/'.$item->id.'/'.$item->slug)}}"><img style="width: 100%; height: 200px" src="@if(isset($item->image)){{asset('storage/avatar/'.$item->image)}} @endif" alt=""></a>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="title">
                                                        <a href="{{asset('realestates/tin/'.$item->id.'/'.$item->slug)}}">
                                                            @if($item->featured==1 ) <p class="noi-bat"><span> </span> {{$item->title}}</p>
                                                            @else <p class="binh-thuong">{{$item->title}}</p> @endif
                                                        </a>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label for="">Giá</label>
                                                        </div>
                                                        <div class="col-md-9">: @if($item->price) {{number_format($item->price)}} VNĐ @else Theo thỏa thuận. @endif</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label for="">Diện tích</label>
                                                        </div>
                                                        <div class="col-md-9">: @if($item->acreage) {{$item->acreage}} mét vuông @else Chưa có thông tin về diện tích. @endif</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label for="">Địa chỉ</label>
                                                        </div>
                                                        <div class="col-md-9">: <span style="color: #00c0ef">{{$item->address}}</span></div>
                                                    </div>
                                                    <div>
                                                        <span style="float: right">{{$item->created_at}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                                    {{$data->links()}}
                            </div>
                            @else
                                <span>Không có tin rao nổi bật nào.</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
{{--            hết content-wap--}}
        </div>
{{--        hết main-create-broker--}}
    </div>
{{--    hêt create_broker--}}

@endsection

@section('js-footer')

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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $("#form").on('change', (function(e){
                var form_code = $(this).val();
                console.log(form_code);
                $.ajax({
                    type:'POST',
                    url:'{{ route('ajax.form3') }}',
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "code": form_code
                    },
                    success:function(data){
                        $('#type').html(data);
                    }
                });
            }));
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
@endsection
