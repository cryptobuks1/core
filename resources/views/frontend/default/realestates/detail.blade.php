@extends('frontend.'.$current_theme.'.common')
@section('title')
@section('customstyle')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
@section('customstyle')


    <style>
        .title{
            text-transform: uppercase;
            text-align: center;
            font-size: 2rem;
            color: #00A6C7;
        }
        .anh-to{
            background-color: #00c0ef;
            border-radius: 6px;
        }
        .anh-to label{
            color: snow;
            padding-top: 5px;
            padding-left: 10px;
        }
        .label label{
            background-color: #00c0ef;
            border-radius: 6px;
            padding: 3px 7px;
            color: gold;
        }
        .anh-nho{
            padding-top: 10px;
        }
        .anh-nho .col-md-3 img{
            width: 100%;
           max-height: 120px;
            padding: 10px;
        }
        .thong-tin-lien-he .thong-tin label,.thong-tin-lien-he .lien-he label{
            color: blue ;
            background-color: #00ffff;
            padding: 3px 5px;
            border-radius: 4px;
            width: 100%;
        }
        .thong-tin-lien-he .thong-tin .tt-lb{
            transform: translateX(-14px);
        }
        .thong-tin-lien-he .thong-tin{
            background-color: floralwhite;
        }
        .lien-he .tt-chi-tiet{
            padding-bottom: 10px;
        }
        .binh-thuong{
            font-weight: 700; color: gray; font-size: 15px
        }
        .noi-bat{
            font-weight: 700; color: orangered; font-size: 15px
        }
        .carousel-item img{
            height: 500px;
        }
    </style>
@endsection

@section('content')

    <div class="detail" style="padding-bottom: 30px">
        <div class="top-header">
            <div class="title">
                <label for="">{{$data->title}}</label>
            </div>
            <div class="header">
                <div class="thong-tin">
                    <p><b>Địa chỉ: </b> <span style="color: #00A6C7">{{$data->address}}</span></p>
                </div>
                <div>
                    <p><b>Giá:</b><span style="color: green">
                            @if($data->price) {{number_format($data->price)}} @else Liên hệ để biết giá cả. @endif</span></p>
                    <p><b>Diện tích:</b><span style="color: green"> @if($data->acreage) {{$data->acreage}} mét vuông @else Liên hệ để biết thêm về diện tích. @endif</span></p>
                </div>
                <div class="mo-ta">
                    <p><label for="" style="color: gray">Thông tin mô tả</label></p>
                    <textarea name="" READONLY   style="border: none; width: 100%;height: 200px ">{{$data->description}}</textarea>
                </div>
            </div>
        </div>
{{--        hết top-header --}}
        <div class="image"style="padding-top: 30px">
            <div class="anh-to" >
                <div class="">
                    <label for="">Ảnh</label>
                </div>
{{--               slide--}}
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img style="width: 100%; max-height: 500px;" class="d-block w-100" src="@if(isset($data->image)){{asset('storage/avatar/'.$data->image)}} @endif" alt="">
                        </div>
                        @if(count($img)>0)
                            @foreach($img as $item)
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="{{asset('storage/avatar/'.$item->img)}}" alt="">
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
{{--                het slide--}}
            </div>
            <div class="anh-nho">
                <div class="row">
                    @if(count($img)>0)
                    @foreach($img as $item)
                    <div class="col-md-3">
                        <img src="{{asset('storage/avatar/'.$item->img)}}" alt="">
                    </div>
                    @endforeach
                        @endif
                </div>
            </div>
        </div>
{{--        hết image--}}
        @if($data->project)
            <div class="du-an" >
                <div class="col-md-12 ">
                    <div class="thong-tin ">
                        <div class=" tt-lb">
                            <label for="" style="font-size: 15px; color: #00c0ef" >Thông tin dự án   </label>
                        </div>
                        <div class="row tt-chi-tiet">
                            <div class="col-md-4">
                                <span style="color: #00c0ef">Tên dự án</span>
                            </div>
                            <div class="col-md-8">
                                <span>{{$project->name}}</span>
                            </div>
                            <hr>
                        </div>
                        @if($project->address)
                            <div class="row tt-chi-tiet">
                                <div class="col-md-4">
                                    <span style="color: #00c0ef">Địa chỉ</span>
                                </div>
                                <div class="col-md-8">
                                    <span>{{$project->address}}</span>
                                </div>
                                <hr>
                            </div>
                        @endif
                        @if($project->investor)
                            <div class="row tt-chi-tiet">
                                <div class="col-md-4">
                                    <span style="color: #00c0ef">Chủ đầu tư</span>
                                </div>
                                <div class="col-md-8">
                                    <span>{{$project->investor}}</span>
                                </div>
                                <hr>
                            </div>
                        @endif
                        @if($project->acreage)
                            <div class="row tt-chi-tiet">
                                <div class="col-md-4">
                                    <span style="color: #00c0ef">Diện tích</span>
                                </div>
                                <div class="col-md-8">
                                    <span>{{$project->acreage}} mét vuông</span>
                                </div>
                                <hr>
                            </div>
                        @endif
                        <div class="row tt-chi-tiet">
                            <div class="col-md-4">
                                <a href="{{asset(asset('realestates/du-an/'.$project->slug.'/'.$project->id))}}" class="btn btn-warning">Chi tiết dự án</a>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>

        @endif
        <div class="thong-tin-lien-he" >
            <div class="col-md-7 thong-tin">
                <div class="  tt-lb">
                    <label for="" >Đặc điểm bất động sản</label>
                </div>
                <div class="row tt-chi-tiet">
                    <div class="col-md-4">
                        <span style="color: #00c0ef">Loại tin rao</span>
                    </div>
                    <div class="col-md-8">
                        <span>{{$data->type}}</span>
                    </div>
                    <hr>
                </div>
                @if($data->project)
                    <div class="row tt-chi-tiet">
                        <div class="col-md-4">
                            <span style="color: #00c0ef">Dự án</span>
                        </div>
                        <div class="col-md-8">
                            <span>{{$data->project}}</span>
                        </div>
                        <hr>
                    </div>
                @endif
                @if($data->facade)
                <div class="row tt-chi-tiet">
                    <div class="col-md-4">
                        <span style="color: #00c0ef">Mặt tiền</span>
                    </div>
                    <div class="col-md-8">
                        <span>{{$data->facade}} m</span>
                    </div>
                    <hr>
                </div>
                @endif
                @if($data->way_in && $data->type !='Bán đất')
                <div class="row tt-chi-tiet">
                    <div class="col-md-4">
                        <span style="color: #00c0ef">Đường vào</span>
                    </div>
                    <div class="col-md-8">
                        <span>{{$data->way_in}} m</span>
                    </div>
                    <hr>
                </div>
                @endif
                @if($data->floor && $data->type !='Bán đất')
                <div class="row tt-chi-tiet">
                    <div class="col-md-4">
                        <span style="color: #00c0ef">Số tầng</span>
                    </div>
                    <div class="col-md-8">
                        <span>{{$data->floor}} Tầng</span>
                    </div>
                    <hr>
                </div>
                @endif
                @if($data->direction && $data->type !='Bán đất')
                <div class="row tt-chi-tiet">
                    <div class="col-md-4">
                        <span style="color: #00c0ef">Hướng nhà</span>
                    </div>
                    <div class="col-md-8">
                        <span>{{$data->direction}}</span>
                    </div>
                    <hr>
                </div>
                @endif
                @if($data->directio_balcony && $data->type !='Bán đất' )
                <div class="row tt-chi-tiet">
                    <div class="col-md-4">
                        <span style="color: #00c0ef">Hướng ban công</span>
                    </div>
                    <div class="col-md-8">
                        <span>{{$data->directio_balcony}}</span>
                    </div>
                    <hr>
                </div>
                @endif
                @if($data->bedroom && $data->type !='Bán đất')
                <div class="row tt-chi-tiet">
                    <div class="col-md-4">
                        <span style="color: #00c0ef">Số phòng ngủ</span>
                    </div>
                    <div class="col-md-8">
                        <span>{{$data->bedroom}} </span>
                    </div>
                    <hr>
                </div>
                @endif
                @if($data->toilet && $data->type !='Bán đất')
                <div class="row tt-chi-tiet">
                    <div class="col-md-4">
                        <span style="color: #00c0ef">Số toilet</span>
                    </div>
                    <div class="col-md-8"toilet>
                        <span>{{$data->toilet}}</span>
                    </div>
                    <hr>
                </div>
                @endif

            </div>
{{--            het đặc điểm--}}

            <div class="col-md-5 lien-he" >
                <div class="  tt-lb">
                    <label for="">Liên hệ</label>
                </div>

                @if($data->name_contact)
                <div class="row tt-chi-tiet">
                    <div class="col-md-4">
                        <span style="color: #00c0ef">Tên liên lạc:</span>
                    </div>
                    <div class="col-md-8">
                        <span>{{$data->name_contact}}</span>
                    </div>
                </div>
                @endif
                @if($data->phone_contact)
                <div class="row tt-chi-tiet">
                    <div class="col-md-4">
                        <span style="color: #00c0ef">Di động:</span>
                    </div>
                    <div class="col-md-8">
                        <span>{{$data->phone_contact}}</span>
                    </div>
                </div>
                @endif
                @if($data->address_contact)
                <div class="row tt-chi-tiet">
                    <div class="col-md-4">
                        <span style="color: #00c0ef">Địa chỉ:</span>
                    </div>
                    <div class="col-md-8">
                        <span>{{$data->address_contact}}</span>
                    </div>
                </div>
                @endif
                @if($data->email_contact)
                <div class="row tt-chi-tiet">
                    <div class="col-md-4">
                        <span style="color: #00c0ef">Email:</span>
                    </div>
                    <div class="col-md-8">
                        <span>{{$data->email_contact}}</span>
                    </div>
                </div>
                @endif
            </div>
{{--            het lien he--}}
        <hr>


        @if($data->furniture && $data->type !='Bán đất')
        <div class="noi-that col-md-12" style="padding-top: 15px">
            <div>
                <label for="" style="color: blue">Nội Thất</label>
            </div>
            <div>
                {{$data->furniture}}
            </div>
        </div>
        @endif
{{--        hết đặc điểm--}}
        <div class="tin-dang col-md-12" >
            <hr>
            <div class="row">
                <div class="col-md-2" >
                   <span style="color: blue">Mã tin đăng:</span><span> {{$data->id}}</span>
                </div>
                <div class="col-md-4">
                    <span style="color: blue">Loại hình:</span>
                    <span>
                            @if($data->featured==1)
                                <span style="color: red">Tin Vip</span>
                            @else<span>Tin Thường</span>
                            @endif
                    </span>
                </div>
                <div class="col-md-3">
                    <span style="color: blue">Ngày đăng:</span><span> {{$data->start_date}}</span>
                </div>
                <div class="col-md-3">
                    <span style="color: blue">Ngày hết hạn:</span><span> {{$data->end_date}}</span>
                </div>
            </div>
        </div>
        </div>
{{--het tin dang--}}
    </div >
{{--hết detail--}}
@endsection
@section('js-footer')
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>

@endsection
