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
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
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

        tr:first-child {
            border-top:none;
        }
        tr:last-child {
            border-bottom:none;
        }
        tr:nth-child(odd) td {
            background:#EBEBEB;
        }

        tr:last-child td:first-child {
            border-bottom-left-radius:3px;
        }
        tr:last-child td:last-child {
            border-bottom-right-radius:3px;
        }
        td {
            padding: 3px;
            background:#FFFFFF;
            vertical-align:middle;
            text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
            border-right: 1px solid #C1C3D1;
        }
        td:last-child {
            border-right: 0px;
        }
        th.text-left {
            text-align: center;
        }
        td.text-left {
            text-align: left;
        }
        td.text-center {
            text-align: center;
        }
        td.text-right {
            text-align: right;
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
                        <h3 class="card-title" style="text-align: center; text-transform: uppercase; color: #0b6998">Danh sách chuyến bay</h3>
                        <div class="card-tools ">
                            <div class="input-group input-group-sm dataTables_filter" style="width: 150px;">
                            </div>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <form action="" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-body" style="padding-top: 50px;">
                            @if(count($datas['ListFareData']) > 0 )
                                <div class="col-sm-12 ">
                                    <div class="col-md-12" style="text-align: center; color: #e84e0f">
                                        <h3>{{$start->city_vi}} <i class="fa fa-arrow-right" aria-hidden="true"></i> {{$end->city_vi}}</h3>
                                        <h3>Đi ngày: {{$start_time}} @if($datas['Itinerary'] == 2)---- Về ngày: {{$end_time}} @endif</h3>
                            </div>
                                    <table id="example1" class=" table-fill table table-bordered table-striped dataTable" >
                            <thead>
                            <tr style="text-align: center">
                                <th>Ngày bay</th>
                                <th>Hành trình</th>
                                <th>Hãng hàng không</th>
                                <th>Giá cơ bản</th>
                                <th>Tổng</th>
                                <th>Chi tiết</th>
                            </tr>
                            </thead>
                            <tbody class="table-hover">
                                @foreach($datas['ListFareData'] as $keyy => $data)
                                        <tr data-toggle="collapse" data-target="{{'#'.$keyy}}" class="accordion-toggle">
                                            <td style="">
                                                <span style="background:none; color: inherit" class="badge">{{\Carbon\Carbon::parse($data['ListFlight'][0]['StartDate'])->format('d-m-Y H:i')}}</span>
                                            </td>
                                            <td>
                                                @if($data['Leg'] == 0 && $data['Itinerary'] == 2 ) Đi và về
                                                @elseif($data['Leg'] == 0 && $data['Itinerary'] == 1 ) Chiều đi
                                                @else Chiều về @endif
                                            </td>
                                            <td>
                                                @foreach($airline as $key => $item)
                                                    @if($item->code == $data['Airline'])
                                                        {{$item->name}}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{number_format($data['FareAdt'],0).''.$data['Currency']}}</td>
                                            <td><h5 class="red">{{number_format($data['TotalNetPrice'],0).''.$data['Currency']}}</h5></td>
                                            <td style="text-align: center"><a link="{{ url($backendUrl.'/flight/checkin/'.$datas['Session'].'/'.$data['FareDataId'].'/'.$data['ListFlight'][0]['FlightValue']) }}" class="btn btn-primary"><i class="fa fa-asterisk" aria-hidden="true"></i></a></td>
                                        </tr>
                                        <tr>
                                        <td colspan="6"  class="hiddenRow"><div id="{{$keyy}}" class="accordian-body collapse"><div style="">
                                                    @foreach($data['ListFlight'] as $key => $item)
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-8 col-xs-6" @if($data['Leg'] == 0 && ($key == 0)) style="color: palevioletred" @endif>
                                                                    <div class="row">
                                                                        <div class="col-md-5">@foreach($stations as $station) @if($item['StartPoint'] == $station->code)
                                                                                {{$station->city_vi}}
                                                                                ({{\Carbon\Carbon::parse($item['StartDate'])->format('d-m-Y H:i')}})<br>
                                                                                {{$station->name}}
                                                                            @endif @endforeach</div>
                                                                        <div class="col-md-2"><i class="fa fa-arrow-right" aria-hidden="true"></i></div>
                                                                        <div class="col-md-5">@foreach($stations as $station) @if($item['EndPoint'] == $station->code)
                                                                                {{$station->city_vi}}
                                                                                ({{\Carbon\Carbon::parse($item['EndDate'])->format('d-m-Y H:i')}})<br>
                                                                                {{$station->name}}
                                                                            @endif @endforeach</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 col-xs-3">
                                                                    <h5>@foreach($airline as $key => $air)
                                                                            @if($air->code == $data['Airline'])
                                                                                {{$air->name}}
                                                                            @endif
                                                                        @endforeach</h5>
                                                                </div>
                                                                <div class="col-md-2 col-xs-3">
                                                                    <h6>Chuyến bay: {{$item['FlightNumber']}}</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <div class="col-md-12">
                                                        <table>
                                                            <thead>
                                                            <tr>
                                                                <th style=" padding: 0">Loại</th>
                                                                <th style=" padding: 0">Số lượng</th>
                                                                <th style=" padding: 0">Giá</th>
                                                                <th style=" padding: 0">Thuế+Phí</th>
                                                                <th style=" padding: 0">Tổng</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>Người lớn</td>
                                                                <td  style="text-align: center">{{$data['Adt']}}</td>
                                                                <td>{{number_format($data['FareAdt'],0).''.$data['Currency']}}</td>
                                                                <td>{{number_format($data['FeeAdt'] + $data['TaxAdt'],0).''.$data['Currency']}}</td>
                                                                <td>{{number_format($data['FareAdt'] + $data['FeeAdt'] + $data['TaxAdt'] + $data['ServiceFeeAdt'],0).''.$data['Currency']}}</td>
                                                            </tr>
                                                            @if($data['Chd'] > 0)
                                                                <tr>
                                                                    <td>Trẻ em</td>
                                                                    <td style="text-align: center">{{$data['Chd']}}</td>
                                                                    <td>{{number_format($data['FareChd'],0).''.$data['Currency']}}</td>
                                                                    <td>{{number_format($data['FeeChd'] + $data['TaxChd'],0).''.$data['Currency']}}</td>
                                                                    <td>{{number_format($data['FareChd'] + $data['FeeChd'] + $data['TaxChd'] + $data['ServiceFeeChd'],0).''.$data['Currency']}}</td>
                                                                </tr>

                                                            @endif
                                                            @if($data['Inf'] > 0)
                                                                <tr>
                                                                    <td>Em bé</td>
                                                                    <td style="text-align: center">{{$data['Inf']}}</td>
                                                                    <td>{{number_format($data['FareInf'],0).''.$data['Currency']}}</td>
                                                                    <td>{{number_format($data['FeeInf'] + $data['TaxInf'],0).''.$data['Currency']}}</td>
                                                                    <td>{{number_format($data['FareInf'] + $data['FeeInf'] + $data['TaxInf'] + $data['ServiceFeeInf'],0).''.$data['Currency']}}</td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td colspan="2">Tổng tiền:</td>
                                                                <td colspan="3"><h5 class="red">{{number_format($data['TotalNetPrice'],0).''.$data['Currency']}}</h5></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div></div></td>
                                        </tr>

                                @endforeach
                            </tbody>
                        </table>
                                </div>
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
