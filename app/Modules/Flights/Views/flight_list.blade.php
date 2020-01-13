@extends('master')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.css') }}">

    <style>
        .red{
            color: red;
        }
        #preview img {
            padding: 10px;
        }
    </style>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="col-md-12">
            <!-- general form elements -->
           @include('layouts.errors')

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Đặt vé</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::open(array('route' => 'flight.list','method'=>'POST','enctype' => 'multipart/form-data')) !!}
                <div class="card-body row">
                    <div class="col-md-12">
                        <h3 style="color: #00aced">Danh sách tìm kiếm</h3>
                        <br>
                    </div>
                        @if(count($datas["ListFareData"]) > 0)
                            @if( $datas['Itinerary'] == 2 )
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center">
                                        <h5>{{$start->city_vi}} <i class="fa fa-arrow-right" aria-hidden="true"></i> {{$end->city_vi}}</h5>
                                        <h5>Đi ngày: {{$start_time}} ---- Về ngày: {{$end_time}}</h5>
                                    </div>
                                    <div class="col-md-12">
                                        <table id="example1" class="table table-bordered table-striped dataTable">
                                            <thead>
                                            <tr style="text-align: center">
                                                <th>Hãng hàng không</th>
                                                <th>Tuyến bay</th>
                                                <th>Mã chuyến bay</th>
                                                <th>Giờ bay</th>
                                                <th>Giá vé</th>
                                                <th>Phí + Thuế</th>
                                                <th>Tổng</th>
                                                <th>Chi tiết</th>
                                                <th>Đặt ngay</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($datas['ListFareData'] as $data)
                                                @if($data['Leg'] == 0 )
                                                    <tr>
                                                        <td>
                                                            @foreach($airline as $item)
                                                                @if($item->code == $data['Airline'])
                                                                    {{$item->name}}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td>{{$start->city_vi.' - '.$end->city_vi}} <br>
                                                            {{$end->city_vi.' - '.$start->city_vi}}
                                                        </td>
                                                        <td>{{$data['ListFlight'][0]['FlightNumber']}} <br>
                                                            {{$data['ListFlight'][1]['FlightNumber']}}
                                                        </td>
                                                        <td style="">
                                                            {{\Carbon\Carbon::parse($data['ListFlight'][0]['StartDate'])->format('d-m-Y H:i').'  ->  '.\Carbon\Carbon::parse($data['ListFlight'][0]['EndDate'])->format('d-m-Y H:i')}}
                                                            <br>
                                                            {{\Carbon\Carbon::parse($data['ListFlight'][1]['StartDate'])->format('d-m-Y H:i').'  ->  '.\Carbon\Carbon::parse($data['ListFlight'][1]['EndDate'])->format('d-m-Y H:i')}}
                                                        </td>
                                                        <td>{{number_format($data['FareAdt'],0).''.$data['Currency']}}</td>
                                                        <td>{{number_format($data['FeeAdt'] + $data['TaxAdt'],0).''.$data['Currency']}}</td>
                                                        <td>{{number_format($data['TotalNetPrice'],0).''.$data['Currency']}}</td>
                                                        <td style="text-align: center">
                                                            <button type="button"  class="btn btn-success deleteClick" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-info-circle" aria-hidden="true"></i></button>
                                                        </td>
                                                        <td style="text-align: center"><a href="{{ url($backendUrl.'/flight/checkin/'.$datas['Session'].'/'.$data['FareDataId'].'/'.$data['ListFlight'][0]['FlightValue']) }}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></a></td>

                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            @elseif($datas['Itinerary'] == 1)
                                @if(count($datas['ListFareData']) > 0 )
                                    <div @if($end_time == null) class="col-md-12 container"  @else class="col-md-6" @endif >
                                        <div class="col-md-12" style="text-align: center">
                                            <h5>{{$start->city_vi}} <i class="fa fa-arrow-right" aria-hidden="true"></i> {{$end->city_vi}}</h5>
                                            <h5>Ngày {{$start_time}}</h5>
                                        </div>
                                        <div class="col-md-12" >
                                            <table   id="example1" class="table table-bordered table-striped dataTable">
                                                <thead>
                                                <tr style="text-align: center">
                                                    <th>Hãng hàng không</th>
                                                    <th>Mã chuyến bay</th>
                                                    <th>Giờ bay</th>
                                                    <th>Giá vé</th>
                                                    <th>Phí + Thuế</th>
                                                    <th>Tổng</th>
                                                    <th>Chi tiết</th>
                                                    <th>Đặt ngay</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($datas['ListFareData'] as $data)
                                                        @if($data['Leg'] == 0 )
                                                            <tr>
                                                                <td>
                                                                    @foreach($airline as $key => $item)
                                                                        @if($item->code == $data['Airline'])
                                                                            {{$item->name}}
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                                <td>{{$data['ListFlight'][0]['FlightNumber']}}</td>
                                                                <td style="">{{\Carbon\Carbon::parse($data['ListFlight'][0]['StartDate'])->format('H:i')}}</td>
                                                                <td>{{number_format($data['FareAdt'],0).''.$data['Currency']}}</td>
                                                                <td>{{number_format($data['FeeAdt'] + $data['TaxAdt'],0).''.$data['Currency']}}</td>
                                                                <td>{{number_format($data['TotalNetPrice'],0).''.$data['Currency']}}</td>
                                                                <td style="text-align: center">
                                                                    <button type="button"  class="btn btn-success deleteClick" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-info-circle" aria-hidden="true"></i></button>
                                                                </td>
                                                                <td style="text-align: center"><a href="{{ url($backendUrl.'/flight/checkin/'.$datas['Session'].'/'.$data['FareDataId'].'/'.$data['ListFlight'][0]['FlightValue']) }}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></a></td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                                @if(count($datas['ListFareData']) > 0 && $end_time != null)
                                    <div class="col-md-6">
                                        <div class="col-md-12" style="text-align: center">
                                            <h5>{{$end->city_vi}} <i class="fa fa-arrow-right" aria-hidden="true"></i> {{$start->city_vi}}</h5>
                                            <h5>Ngày {{$end_time}}</h5>
                                        </div>
                                        <div class="col-md-12">
                                            <table id="example1" class="table table-bordered table-striped dataTable">
                                                <thead>
                                                <tr style="text-align: center">
                                                    <th>Hãng hàng không</th>
                                                    <th>Mã chuyến bay</th>
                                                    <th>Giờ bay</th>
                                                    <th>Giá vé</th>
                                                    <th>Phí + Thuế</th>
                                                    <th>Tổng</th>
                                                    <th>Chi tiết</th>
                                                    <th>Đặt ngay</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($datas['ListFareData'] as $data)
                                                    @if($data['Leg'] == 1 )
                                                        <tr>
                                                            <td>
                                                                @foreach($airline as $item)
                                                                    @if($item->code == $data['Airline'])
                                                                        {{$item->name}}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td>{{$data['ListFlight'][0]['FlightNumber']}}</td>
                                                            <td style="">{{\Carbon\Carbon::parse($data['ListFlight'][0]['StartDate'])->format('H:i')}}</td>
                                                            <td>{{number_format($data['FareAdt'],0).''.$data['Currency']}}</td>
                                                            <td>{{number_format($data['FeeAdt'] + $data['TaxAdt'],0).''.$data['Currency']}}</td>
                                                            <td>{{number_format($data['TotalNetPrice'],0).''.$data['Currency']}}</td>
                                                            <td style="text-align: center">
                                                                <button type="button"  class="btn btn-success deleteClick" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-info-circle" aria-hidden="true"></i></button>
                                                            </td>
                                                            <td style="text-align: center"><a href="{{ url($backendUrl.'/flight/checkin/'.$datas['Session'].'/'.$data['FareDataId'].'/'.$data['ListFlight'][0]['FlightValue']) }}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></a></td>
                                                        </tr>

                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @else
                            <h4>Không có chuyến bay nào</h4>
                        @endif

                </div>

                <!-- /.card-body -->

                    @csrf
                {!! Form::close() !!}
            </div>
            <!-- /.card -->
      </div>
    </div>
  </div>


</section>
<!-- /.content -->
@endsection
@section('js')
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".deleteClick").click(function(){

            });
        });
    </script>

@endsection
