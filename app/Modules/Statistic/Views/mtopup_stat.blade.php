@extends('master')

@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({
                dateFormat: 'dd-mm-yy',
                showButtonPanel: true
            });
            $( "#datepicker2" ).datepicker({
                dateFormat: 'dd-mm-yy',
                showButtonPanel: true
            });
        } );
    </script>

@endsection

@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card table-responsive">

                    <div class="card-header" style="border-bottom: 0">
                        <div class="card-tools " style="float: left;position: relative;right: 0px;left: 0px;">
                            <div class="input-group input-group-sm dataTables_filter" style="">
                                <form action="" name="formSearch" method="GET" >
                                    <div class="input-group">
                                        <select name="service_code" class="form-control" style="">
                                            <option value="" @if(app("request")->input("service_code")=="") selected="selected" @endif>Loại thẻ</option>
                                            @if(count($servicecodes))
                                            @foreach($servicecodes as $servicecode)
                                            <option value="{{$servicecode->service_code}}" @if(app("request")->input("service_code")==$servicecode->service_code) selected="selected" @endif>{{$servicecode->service_code}}</option>
                                                @endforeach
                                                @endif
                                        </select>

                                        <select name="status" class="form-control" style="">
                                            <option value="" @if(app("request")->input("status")== "") selected="selected" @endif>Trạng thái</option>
                                            <option value="completed" @if(app("request")->input("status")== "completed") selected="selected" @endif>Thành công</option>
                                            <option value="pending" @if(app("request")->input("status")== "pending") selected="selected" @endif>Chờ xử lý</option>
                                            <option value="canceled" @if(app("request")->input("status")== "canceled") selected="selected" @endif>Hủy bỏ</option>
                                        </select>

                                        <select name="provider" class="form-control" style="">
                                            <option value="" @if(app("request")->input("provider")== "") selected="selected" @endif>Nhà cung cấp</option>
                                            <option value="Me" @if(app("request")->input("provider")== 'Me') selected="selected" @endif>Tự nạp thủ công</option>
                                            @if(count($providers) > 0)
                                            @foreach($providers as $provider)
                                            <option value="{{$provider->provider}}" @if(app("request")->input("provider")== $provider->provider) selected="selected" @endif>{{$provider->provider}}</option>
                                                @endforeach
                                                @endif
                                        </select>

                                        <input class="form-control" value="@if(app("request")->input("fromdate")){{ trim(app("request")->input("fromdate"))}}@else{{ trim(date('d-m-Y', time()))}}@endif" name="fromdate" id="datepicker">
                                        <input class="form-control" value="@if(app("request")->input("todate")){{ trim(app("request")->input("todate"))}}@else{{ trim(date('d-m-Y', time()))}}@endif" name="todate" id="datepicker2">

                                        <input class="form-control" value="@if(app("request")->input("user_id")){{ trim(app("request")->input("user_id"))}}@endif" name="user_id" placeholder="Mã KH">


                                        <div class="input-group-append">
                                            <button type="submit" name="submit" value="filter" class="btn btn-warning"><i class="fa fa-search"></i> Lọc</button>
                                            <button type="submit" name="submit" value="excel" class="btn btn-success"><i class="fa fa-download"></i> Excel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="padding-top: 0;">
                        <div class="row"><div class="col-sm-12">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped dataTable">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Khách hàng</th>
                                            <th>Thuê bao</th>
                                            <th>Mã dịch vụ</th>
                                            <th>NNC</th>
                                            <th>Cần nạp</th>
                                            <th>Đã nạp</th>
                                            <th>Thanh toán</th>
                                            <th>Trạng thái</th>
                                            <th>Mã KH</th>
                                            <th>Ngày tạo</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(!count($mtopups))
                                            <tr>
                                                <td colspan="10" class="text-center alert alert-light">Chưa có dữ liệu</td>
                                            </tr>
                                        @else
                                            @foreach( $mtopups as $s_order )
                                                <tr>
                                                    <td>{{ $s_order->order_code }}</td>
                                                    <td>{!! App\User::getUserInfo($s_order->user) !!}</td>
                                                    <td>{{ $s_order->phone_number }}</td>
                                                    <td>{{ $s_order->service_code }}</td>
                                                    <td>{{ $s_order->provider }}</td>
                                                    <td>{{ number_format($s_order->declared_value) }} {{ $s_order->currency_code }}</td>
                                                    <td>{{ number_format($s_order->completed_value) }} {{ $s_order->currency_code }}</td>
                                                    <td>{{ number_format($s_order->amount) }} {{ $s_order->currency_code }}</td>
                                                    <td>
                                                        @if($s_order->status == 'completed')
                                                            <label class="badge badge-success">HOÀN THÀNH</label>
                                                        @elseif($s_order->status == 'pending')
                                                            <label class="badge badge-warning">CHỜ XỬ LÝ</label>
                                                        @elseif($s_order->status == 'none')
                                                            <label class="badge badge-secondary">NHÁP</label>
                                                        @elseif($s_order->status == 'canceled')
                                                            <label class="badge badge-danger">ĐÃ HỦY</label>
                                                        @else
                                                            <label class="badge badge-dark">CHƯA RÕ</label>
                                                        @endif

                                                    </td>
                                                    <td>{{ $s_order->user }}</td>
                                                    <td>{{ $s_order->created_at }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot>

                                        <tr>

                                            <th colspan="5" class="text-right">Tổng số:</th>
                                            <th>{{ number_format($total->sum('declared_value')) }} </th>
                                            <th>{{ number_format($total->sum('completed_value')) }} </th>
                                            <th>{{ number_format($total->sum('amount')) }} </th>
                                            <th colspan="3"></th>

                                        </tr>
                                        </tfoot>

                                    </table>

                                </div>
                            </div></div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="float-right" id="dynamic-table_paginate">
                                    {{$mtopups->appends(request()->query())->links()}}
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Delete form -->


                    <!-- End Delete form-->


                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection


