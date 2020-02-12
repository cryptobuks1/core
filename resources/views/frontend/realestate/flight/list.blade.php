@extends('frontend.'.$current_theme.'.app')
@section('title')
@section('customstyle')

@section('customstyle')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .red{
            color: red;
        }
        @import url(https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100);
        body {
            font-family: "Roboto", helvetica, arial, sans-serif;
            text-rendering: optimizeLegibility;
        }
        div.table-title {
            display: block;
            margin: auto;
            max-width: 600px;
            padding:5px;
            width: 100%;
        }
        .table-title h3 {
            color: #fafafa;
            font-size: 30px;
            font-weight: 400;
            font-style:normal;
            font-family: "Roboto", helvetica, arial, sans-serif;
            text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
            text-transform:uppercase;
        }
        /*** Table Styles **/
        .table-fill {
            background: white;
            border-radius:3px;
            border-collapse: collapse;
            margin: auto;
            padding:5px;
            width: 100%;
            /*box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);*/
            animation: float 5s infinite;
        }
        th {
            color:white;;
            background:#0a3461;
            border-bottom:4px solid #9ea7af;
            border-right: 1px solid #343a45;
            font-size:15px;
            font-weight: 100;
            padding:24px;
            text-align: center;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            vertical-align:middle;
        }
        th:first-child {
            border-top-left-radius:3px;
        }
        th:last-child {
            border-top-right-radius:3px;
            border-right:none;
        }
        tr {
            border-top: 1px solid #C1C3D1;
            border-bottom-: 1px solid #C1C3D1;
            color:#666B85;
            font-weight:normal;
            text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
        }


        td {
            background:#FFFFFF;
            vertical-align:middle;
            text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);

        }
        hr {
            margin: 5px;
        }
        .table-main .row{
            margin-left: -10px;
            padding-right: 0;
        }
        .table-main .row .row{
            padding-right: -10px;
        }
        .chi-tiet,.name-airline,.img-airline{
            flex-direction: column;
        }

        .img-airline img{
            max-width: 90%;
        }
        .name-airline{
            float: left;
        }
        @media (max-width: 991px) {
            .img-airline{
                max-width: 100%;
                padding-top: 10px;
                padding-left: 5px;
                padding-right: 0;
            }
            .name-airline{
                padding-left: 0;
                padding-top: 10px;
            }
            .chi-tiet{
                padding-top: 20px;

            }
        }

    </style>

@endsection

@section('content')
    @include('frontend.default.realestates.menu')
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card">
                    <div class="card-header" style="border-bottom: 0">
                        <h2 class="card-title" style="text-align: center; text-transform: uppercase; color: #dc3545; font-size: 25px">Danh sách chuyến bay</h2>
                        <div class="card-tools ">
                            <div class="input-group input-group-sm dataTables_filter" style="width: 150px;">
                            </div>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <form action="" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-body" style="padding-top: 10px">
                            @if(count($datas) > 0 )
                            <table id="example1" class=" table-fill table-responsive table table-striped dataTable" style=" background: #f1f1f1 none repeat scroll 0 0">
                            <tbody class="table-hover">
                            @foreach($datas as $keyy => $items)
                                @if(count($items) > 0)
                                    <tr class="table-main">
                                        <td width="80%" style="  padding-left: 18px;">
                                            @foreach($items as $i => $data)
                                                <div style="width: 100%; padding-top: 10px;" >
                                                    <div class="row" @if($data['Departure'] == $StartPoint) style="color: #0e84b5" @else style="color: #0c0c0c" @endif>
                                                        <div class="col-md-7 col-xs-6" style="padding-right: 0">
                                                            <div class="row">
                                                                <div class="col-md-5" ><span> @foreach($Stations as $station) @if($station->code == $data['Departure']) {{$station->city_vi.' ('.$data['Departure'].')'}} <br> ({{$data['DepartureDate'].' '.$data['DepartureTime']}}) @endif @endforeach</span></div>
                                                                <div class="col-md-2"><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
                                                                <div class="col-md-5"><span>@foreach($Stations as $station) @if($station->code == $data['Arrival']) {{$station->city_vi.' ('.$data['Arrival'].')'}} <br> ({{$data['ArrivalDate'].' '.$data['ArrivalTime']}}) @endif @endforeach</span></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5 col-xs-6">
                                                            <div class="col-md-6 col-xs-5 name-airline" >
                                                                <span >{{$data['Airline']}}</span>
                                                            </div>
                                                            <div class="col-md-6 col-xs-7 img-airline">
                                                                @if($data['Airline'] === '')
                                                                    @dd($data['Airline'])
                                                                @endif
                                                                @foreach($airline as $item)
                                                                    @if($item->name === trim($data['Airline']) || trim($item->name_en) === trim($data['Airline']) || $item->code === trim($data['Airline']))
                                                                        <img src="@if($item->image){{ url('/storage/userfiles/images/airlines/'.$item->image) }}@endif" alt="{{$data['Airline']}}" style=" transform: translateY(-9px); max-height: 60px"/>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if(count($items) == 2 && $i < 1) <hr style="border-bottom: 1px solid white"> @endif
                                                </div>
                                            @endforeach
                                        </td>
                                        <td >
                                            <div class="chi-tiet" style="text-align: center; padding-right: 5px;">
                                                @if(count($items) == 1)
                                                    <span class="red" style="font-size: 20px; font-weight: 600"> @if($items[0]['FlightType'] == 0) {{number_format($items[0]['SumPrice']).'VND'}}  @elseif($items[0]['FlightType'] == 1) {{number_format(round($items[0]['SumPrice']+500000)/212.35,0).'¥'}}@endif</span>
                                                @elseif(count($items) > 1)
                                                    <span class="red" style="font-size: 20px; font-weight: 600"> @if($items[0]['FlightType'] == 0) {{number_format($items[0]['SumPrice']).'VND'}}  @elseif($items[0]['FlightType'] == 1) {{number_format(round($items[0]['SumPrice']+1000000)/212.35,0).'¥'}}@endif</span>
                                                @endif
                                                    <div style="padding-top: 5px">
                                                        <button  type="button" data-toggle="collapse" data-target="{{'#'.$keyy}}" class=" btn btn-primary accordion-toggle">Chi tiết</button>
                                                    </div>
                                            </div>
                                        </td>
                                    </tr>
                                        <tr>
                                        <td style="background-color: #f1f1f1" colspan="6"  class="hiddenRow"><div id="{{$keyy}}" class="accordian-body collapse"><div>
                                            @foreach($items as  $data)
                                                @if($data['FlightType'] == 1 && count($items) > 1)
                                                    <div class="col-md-12" style="text-align: center">
                                                            <h6 style="color: #dc3545; padding: 0">{{ $data['Departure'] }} <i class="fa fa-arrow-right" aria-hidden="true"></i> {{ $data['Arrival'] }}</h6>
                                                    </div>
                                                @endif
                                                @foreach($data['Journeys'] as $key =>  $item)
                                                    <div class="col-md-12" >
                                                        <div class="row" >
                                                            <div class="col-md-9 col-xs-9">
                                                                <div class="row">
                                                                    <div class="col-md-5" @if($data['TypeAir'] == 0 && $data['FlightType'] == 0) style="text-align: center" @endif>
                                                                        {{$item['Departure']}}<br>
                                                                        ({{$item['DepartureDate'].' '.$item['DepartureTime']}})
                                                                    </div>
                                                                    <div class="col-md-2"><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
                                                                    <div class="col-md-5" @if($data['TypeAir'] == 0 && $data['FlightType'] == 0) style="text-align: center" @endif>
                                                                        {{$item['Arrival']}}<br>
                                                                        ({{$item['ArrivalDate'].' '.$item['ArrivalTime']}})
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-xs-3">
                                                                Mã chuyến bay: {{$item['FlightNumber']}}
                                                            </div>
                                                        </div>
                                                        @if($data['TypeAir'] == 1 && $key < 1) <hr style="border-bottom: 1px solid white"> @endif

                                                    </div>
                                                @endforeach
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        @else
                            <h5>Không có chuyến bay nào, vui lòng chọn ngày khác</h5>
                        @endif

                        </div>
                    </form>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- Main content -->
@endsection


@section('js-footer')
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
        $(document).ready(function(){
            $(".deleteClick").click(function(){
                var link = $(this).attr('link');
                var name = $(this).attr('name');
                console.log(link);
                $("#deleteForm").attr('action',link);
                $("#deleteMes").html("Delete : "+name+" ?");
            });
        });
            $(document).ready(function(){
                $('.accordian-body').on('show.bs.collapse', function () {
                    $(this).closest("table")
                        .find(".collapse.in")
                        .not(this)
                        .collapse('toggle')
                })
            });
    </script>

@endsection
