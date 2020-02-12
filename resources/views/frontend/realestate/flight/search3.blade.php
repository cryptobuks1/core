@extends('frontend.'.$current_theme.'.app')
@section('title')
@section('customstyle')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
    <style>
        .red{
            color: red;
        }
        #preview img {
            padding: 10px;
        }
        .form-control{
            padding: 0;
            border-radius: 3px;
        }
        input{

        }
        .search{
            margin: 5px;
        }
        .search-title h3 {
            font-size: 3rem;
        }
        .search-title hr{
            width: 50%;
            float: left;
            margin: 0;
        }
        .container{
            max-width: 20000px;
        }
        .carousel-inner img{
            width: 100%;
            max-height: 450px;
        }
        .search-tutorial,.news{
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 15px;
        }
        .row{
            margin: 0;
        }
        .search-main .row .col-md-12{
            padding-left: 5px;
        }
        .form-control{
            padding-left: 3px;
        }
        .tutorial-right{
            border-radius:5px;
        }
        @media (max-width: 991px){
            .flight-demo{
                padding-left: 0;
                padding-right: 0;
            }
            .flight-demo img{
                max-width: 90%;
            }
        }



    </style>

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">



@endsection

@section('content')

    <div class="create-broker" >
        <div class="container">

        </div>
        <div id="main-broker" class="container" style=" background-color: #fafbff;">
            <div class="content-wap" >
                @include('layouts.errors')
                <div class="top-search">
                    <div class="row">
                        <div class="col-md-8" >
                            <div id="myCarousel" class="carousel slide" data-ride="carousel" style="">
                                <!-- Indicators -->
                                <ol class="carousel-indicators">
                                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#myCarousel" data-slide-to="1"></li>
                                    <li data-target="#myCarousel" data-slide-to="2"></li>
                                </ol>

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <div class="item active">
                                        <img src="{{ url('/storage/userfiles/images/maybay1.jpg') }}" alt="">
                                    </div>

                                    <div class="item">
                                        <img src="{{ url('/storage/userfiles/images/vietjet2.jpg') }}" alt="">
                                    </div>

                                    <div class="item">
                                        <img src="{{ url('/storage/userfiles/images/tfd_190314090338_108114.jpg') }}" alt="">
                                    </div>
                                </div>

                                <!-- Left and right controls -->
                                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 " style=" background-color: #dc3545; border-radius: 6px; color: white">
                            <div class="search">
                                    {!! Form::open(array('route' => 'front.flight.list','method'=>'POST')) !!}
                                <div class="search-title">
                                    <h3>Tìm Chuyến Bay</h3>

                                </div>
                                <hr>
                                <div class="search-main">
                                    <div class="row">
                                        <div class="col-md-12" style="padding-top: 10px; padding-left: 14px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span style="padding-right: 15px; float: left">
                                                        <label style="padding-right: 5px">Khứ hồi</label>
                                                        <input type="radio" name="type" id="type2" value="1" style="transform: translateY(3px); padding-left: 10px;" checked>
                                                    </span>
                                                    <span>
                                                        <label style="padding-right: 5px">Một chiều</label>
                                                        <input type="radio" name="type" id="type1" value="0" style="transform: translateY(3px); padding-left: 10px">
                                                    </span>
                                                </div>
                                            </div>
                                            <br>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-3">
                                                    <label>Nơi đi:</label>
                                                </div>
                                                <div class="col-md-9 col-xs-11">
                                                    <select id="departure" class="form-control select2 inv_id" name="StartPoint" required >
                                                        <option value="">Điểm khởi hành</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-3">
                                                    <label>Nơi đến:</label>
                                                </div>
                                                <div class="col-md-9 col-xs-11">
                                                    <select id="arrival" class="form-control select2 inv_id" name="EndPoint" required>
                                                        <option value="">Điểm đến</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-3">
                                                    <label>Ngày đi:</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" style="padding-left: 5px; position: relative" class="form-control "  placeholder="Chọn ngày khởi hành" id="departure_time" name="DepartDate" value="{{old('DepartDate')}}" required>
                                                    <i class="fa fa-calendar" id="calendar1" aria-hidden="true" style="position: absolute; right: 25px; top: 8px; color: #ffd76d"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 DepartDate2" >
                                            <div class="form-group" >
                                                <div class="col-md-3">
                                                    <label>Ngày về:</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" style="padding-left: 5px; position: relative" class="form-control" placeholder="Chọn ngày về" id="arrival_time" name="DepartDate2" value="{{old('DepartDate2')}}">
                                                    <i class="fa fa-calendar" id="calendar2" aria-hidden="true" style="position: absolute; right: 25px; top: 8px; color: #ffd76d"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    <label>Người lớn:</label>
                                                    <input type="number" name="Adt" value="1" max="10" min="1" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    <label>Trẻ em:</label>
                                                    <input type="number" name="Chd" value="0" max="10" min="0" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="form-group">
                                                    <label>Em bé:</label>
                                                    <input type="number" name="Inf" value="0" max="10" min="0" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                        <div class="col-md-12">
                                        <div class="card-footer" style="text-align: center">
                                            <button type="submit" class="btn btn-primary" style=" margin: 10px"><i class="fa fa-search"> </i> Tìm kiếm</button>
                                        </div>
                                    </div>
                                </div>
                                @csrf
                                {!! Form::close() !!}
                            </div>
                        </div>

                    </div>
                </div>
                {{--hết top-search--}}
                <div class="search-tutorial">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12" >
                                <div class="col-md-12" style="border-bottom: 1px dotted #0c0c0c;">
                                    <h3 style="padding-left: 5px; font-size: 20px">Vé Rẻ Mỗi Ngày</h3>
                                </div>
                                    @foreach($datas as $key => $data)
                                        @if($key <= 3)
                                            <div class="col-md-12 flight-demo"  style="padding-top: 10px;  border-bottom: 1px solid gray" >
                                                <div class="box_custor">
                                                    <p><strong>@foreach($stations as $item) @if($item->code == $data['Departure']) {{$item->city_vi}} @endif @endforeach -
                                                            @foreach($stations as $item) @if($item->code == $data['Arrival']) {{$item->city_vi}} @endif @endforeach, Ngày: {{$data['DepartureDate'].' '.$data['DepartureTime']}}</strong></p>
                                                    <div class="row" >
                                                        <div class="col-xs-3 flight-demo">
                                                            @foreach($airline as $item)
                                                                @if($item->name == trim($data['Airline']) || $item->name_en == trim($data['Airline']) || $item->code == trim($data['Airline']))
                                                                    <img class="left_" style="height: 25px; transform: translateY(-3px)" alt="{{$data['Airline']}}" src="@if($item->image){{ url('/storage/userfiles/images/airlines/'.$item->image) }} @endif" />
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="col-xs-5 flight-demo">
                                                            <span class="time-before">Mã chuyến bay: {{$data['FlightNumber']}}</span>
                                                        </div>
                                                        <div class="col-xs-4 flight-demo">
                                                            <span class="bold-font">Giá: </span><span class="bold-font-orange" style="color: red">{{number_format($data['SumPrice'],0).' VND'}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12" >
                                <div class="col-md-12 " style="border-bottom: 1px dotted #0c0c0c;">
                                    <h3 style="padding-left: 5px; font-size: 20px">Hình Thức Mua Vé</h3>
                                </div>

                            </div>
                            <div class="col-xs-12" style="padding-bottom: 5px; padding-top: 10px">
                                <div class="col-xs-1" style="padding-left: 10px; padding-right: 5px">
                                    <h3 style="padding-top: 5px; font-size: 3rem">1</h3>
                                </div>
                                <div class=" col-xs-11 tutorial-right"  style="border: 1px solid #00FFFF;padding-left: 5px; padding-right: 5px">
                                    <h5>Trực Tiếp Lên Website</h5>
                                    <p>Quý khách chủ động tìm vé và tạo booking ngay trên website, sau đó nhân viên sẽ gọi lại để xác nhận booking và xuất vé giao vé cho Quý khách</p>
                                </div>
                            </div>
                            <div class="col-xs-12" style="padding-bottom: 5px">
                                <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px">
                                    <h3 style="font-size: 3rem">2</h3>
                                </div>
                                <div class="col-xs-11 tutorial-right" style="border: 1px solid #00FFFF;padding-left: 5px; padding-right: 5px">
                                    <h5>Gọi Tới HOTLINE</h5>
                                    <p>0943793984</p>
                                </div>
                            </div>
                            <div class="col-xs-12" style="padding-bottom: 5px">
                                <div class="col-xs-1" style="padding-left: 5px; padding-right: 5px">
                                    <h3 style="padding-top: 20px; font-size: 3rem">3</h3>
                                </div>
                                <div class=" col-xs-11 tutorial-right" style="border: 1px solid #00FFFF;padding-left: 5px; padding-right: 5px">
                                    <h5>Đến Trực Tiếp Tại Văn Phòng</h5>
                                    <p>Quý khách có thể đến một trong những địa chỉ dưới đây, nhân viên sẽ tư vấn và xuất vé máy bay cho Quý khách một cách nhiệt tình và chuyên nghiệp nhất.
                                        ĐC: 35-45 Trần Thái Tông, Cầu Giấy, Hà Nội - Tel:  0943793984 - Mail: hotronet@gmail.com   .</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="news">
                    <div class="row" style="margin-top: 15px">
                        @foreach($news as  $item)
                            <div class="col-md-3 col-xs-6" style="text-align: center;padding-left: 5px; padding-right: 5px">
                                <div style="width: 95%">
                                    <a href="{{ url('tin-tuc/'.$item->news_slug) }}"><img src="{{ url($item->image) }}" alt="" style="max-width: 90%; height: 150px; border-radius: 13px;"></a>
                                    <a href="{{ url('tin-tuc/'.$item->news_slug) }}" style="text-transform: uppercase" ><h6>{{$item->title}}</h6></a>
                                </div>

                        </div>
                        @endforeach
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
    <script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/ckeditor4101/ckeditor.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {
            $("#departure,#arrival").select2(
                {
                    tags: true,
                    ajax: {
                        url: "{{ route('ajax.flight.departure2')  }}",
                        type: "POST",
                        dataType: 'json',
                        delay: 150,
                        data: function (params) {
                            return {
                                searchTerm: params.term // search term
                            };
                        },
                        processResults: function (response) {
                            return {
                                results: response
                            };
                        },
                        cache: true
                    }
                }
            );
            $("#airline").select2(
                {
                    tags: true,
                    ajax: {
                        url: "{{ route('ajax.flight.airline2')  }}",
                        type: "POST",
                        dataType: 'json',
                        delay: 150,
                        data: function (params) {
                            return {
                                searchTerm: params.term // search term
                            };
                        },
                        processResults: function (response) {
                            return {
                                results: response
                            };
                        },
                        cache: true
                    }
                }
            );
        });
    </script>
    <script>
        jQuery(function ($)
        {
            $.datepicker.regional["vi-VN"] =
                {
                    closeText: "Đóng",
                    prevText: "Trước",
                    nextText: "Sau",
                    currentText: "Hôm nay",
                    monthNames: ["Tháng một", "Tháng hai", "Tháng ba", "Tháng tư", "Tháng năm", "Tháng sáu", "Tháng bảy", "Tháng tám", "Tháng chín", "Tháng mười", "Tháng mười một", "Tháng mười hai"],
                    monthNamesShort: ["Một", "Hai", "Ba", "Bốn", "Năm", "Sáu", "Bảy", "Tám", "Chín", "Mười", "Mười một", "Mười hai"],
                    dayNames: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"],
                    dayNamesShort: ["CN", "Hai", "Ba", "Tư", "Năm", "Sáu", "Bảy"],
                    dayNamesMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                    weekHeader: "Tuần",
                    dateFormat: "dd/mm/yy",
                    firstDay: 1,
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: ""
                };

            $.datepicker.setDefaults($.datepicker.regional["vi-VN"]);
        });
        $(function () {
            $("#calendar1").on('click', (function(e){
                $('#departure_time').select();
            }));
            $("#calendar2").on('click', (function(e){
                $('#arrival_time').select();
            }));
            $("#departure_time,#arrival_time").datepicker({
                dateFormat: 'dd/mm/yy',
                minDate:'0',
            });


        });
        $(document).ready(function() {

            // $("#departure_time").on('change', (function(e) {
            //     var departure = $('#departure_time').val();
            //     console.log(departure);
            //     $("#arrival_time").datepicker({
            //         dateFormat: 'dd/mm/yy',
            //         minDate: departure,
            //     });
            // }));
            $("#type1").on('click', (function (e) {
                $('.DepartDate2').hide();
            }));
            $("#type2").on('click', (function (e) {
                $('.DepartDate2').show();
            }));
        });
    </script>
@endsection
