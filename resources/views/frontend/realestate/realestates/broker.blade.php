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
        .item-broker h5{
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

    </style>

@endsection

@section('content')

    <div class="create-broker">
        <div class="broker-top">
            <h2>DANH BẠ NHÀ MÔI GIỚI</h2>
        </div>
        <div id="main-broker" class="container">
            <div class="content-wap">
                @include('layouts.errors')
                <div class="row">
                    @include('frontend.realestate.realestates.search_broker')

                    <div class="col-md-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#menu1"><span style="font-size: 15px">Môi giới công ty</span></a></li>
                            <li><a data-toggle="tab" href="#menu2"><span style="font-size: 15px">Môi giới cá nhân</span></a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="menu1" class="tab-pane fade in active">
                                @if(count($brokers2)>0)
                                    @foreach($brokers2 as $broker)
                                        <div class="item-broker">
                                            <div class="row">
                                                <div class="col-md-3" style="padding-bottom: 10px">
                                                    <a href="{{asset('realestates/broker/detail/'.$broker->slug.'/'.$broker->id)}}"><img src="{{asset('/storage/avatar/'.$broker->image)}}" alt="" style="width: 100%" > </a>
                                                </div>
                                                <div class="col-md-6">
                                                    <a href="{{asset('realestates/broker/detail/'.$broker->slug.'/'.$broker->id)}}"><h5>CÔNG TY: {{$broker->name}}</h5></a>
                                                    <p><label for="">Địa chỉ:</label> {{$broker->address}}</p>
                                                    <p><label for="">Số điện thoại</label>: {{$broker->phone}}</p>
                                                    <p><label for="">Email</label>: {{$broker->email}}</p>
                                                    @if($broker->website)
                                                        <p><label for="">Website:</label> <a href="{{$broker->website}}">{{$broker->website}}</a></p>
                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    <h5>LOẠI HÌNH MÔI GIỚI</h5>
                                                    @foreach($broker->fields as $item)
                                                        @foreach($types as $type)
                                                        @if($item==$type->id)
                                                            <p>- {{$type->name}}</p>
                                                        @endif
                                                        @endforeach
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        {{$brokers2->links()}}
                                    @endforeach
                                @else
                                    <p style="text-align: center; font-size: 15px; color: #00c0ef">Không có nhà môi giới nào</p>
                            @endif

                            </div>
                            <div id="menu2" class="tab-pane fade">
                                @if(count($brokers)>0)
                                    @foreach($brokers as $broker)
                                        <div class="item-broker">
                                            <div class="row">
                                                <div class="col-md-3" style="padding-bottom: 10px">
                                                    <a href="{{asset('realestates/broker/detail/'.$broker->slug.'/'.$broker->id)}}"><img src="{{asset('/storage/avatar/'.$broker->image)}}" alt="" style="width: 100%" > </a>
                                                </div>
                                                <div class="col-md-6">
                                                    <a href="{{asset('realestates/broker/detail/'.$broker->slug.'/'.$broker->id)}}"><h5>CÔNG TY: {{$broker->name}}</h5></a>
                                                    <p><label for="">Địa chỉ:</label> {{$broker->address}}</p>
                                                    <p><label for="">Số điện thoại</label>: {{$broker->phone}}</p>
                                                    <p><label for="">Email</label>: {{$broker->email}}</p>
                                                    @if($broker->website)
                                                        <p><label for="">Website:</label> <a href="{{$broker->website}}">{{$broker->website}}</a></p>
                                                    @endif
                                                </div>
                                                <div class="col-md-3">
                                                    <h5>LOẠI HÌNH MÔI GIỚI</h5>
                                                    @foreach($broker->fields as $item)
                                                        @foreach($types as $type)
                                                            @if($item==$type->id)
                                                                <p>- {{$type->name}}</p>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        {{$brokers->links()}}
                                    @endforeach
                                @else
                                    <p style="text-align: center; font-size: 15px; color: #00c0ef">Không có nhà môi giới nào</p>
                                @endif
                            </div>
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
