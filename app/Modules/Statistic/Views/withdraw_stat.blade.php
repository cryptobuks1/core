@extends('master')

@section('css')

@endsection

@section('js')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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

                                        <select name="status" class="form-control" style="">
                                            <option value="" @if(app("request")->input("status")== "") selected="selected" @endif>Trạng thái</option>
                                            <option value="completed" @if(app("request")->input("status")== "completed") selected="selected" @endif>Thành công</option>
                                            <option value="pending" @if(app("request")->input("status")== "pending") selected="selected" @endif>Chờ xử lý</option>
                                            <option value="canceled" @if(app("request")->input("status")== "canceled") selected="selected" @endif>Hủy bỏ</option>
                                            {{--<option value="none" @if(app("request")->input("status")== "none") selected="selected" @endif>Nháp</option>--}}
                                        </select>

                                        <input class="form-control" value="@if(app("request")->input("fromdate")){{ trim(app("request")->input("fromdate"))}}@else{{ trim(date('d-m-Y', time()))}}@endif" name="fromdate" id="datepicker">
                                        <input class="form-control" value="@if(app("request")->input("todate")){{ trim(app("request")->input("todate"))}}@else{{ trim(date('d-m-Y', time()))}}@endif" name="todate" id="datepicker2">

                                        <input class="form-control" value="@if(app("request")->input("user_id")){{ trim(app("request")->input("user_id"))}}@endif" name="user_id" placeholder="Mã khách hàng">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i> Lọc</button>
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
                                            <th>Mã đơn</th>
                                            <th>Khách hàng</th>
                                            <th>Số tiền</th>
                                            <th>Ngân hàng</th>
                                            <th>Trạng thái</th>
                                            <th>Mã khách hàng</th>
                                            <th>Ngày tạo</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(!count($withdraws))
                                            <tr>
                                                <td colspan="9" class="text-center alert alert-info">Chưa có dữ liệu</td>
                                            </tr>
                                        @else
                                            @foreach( $withdraws as $s_order )
                                                <tr>
                                                    <td>{{ $s_order->order_code }}</td>
                                                    <td>{!! App\User::getUserInfo($s_order->payer_id) !!}</td>
                                                    <td>{{ number_format($s_order->net_amount) }} {{ $s_order->currency_code }}</td>
                                                    <td>{!! $s_order->payer_info !!} </td>
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
                                                    <td>{{ $s_order->payer_id }}</td>
                                                    <td>{{ $s_order->created_at }}</td>

                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot>

                                        <tr>

                                            <th colspan="2" class="text-right">Tổng số:</th>
                                            <th>{{ number_format($total->sum('net_amount')) }}</th>
                                            <th colspan="4"></th>

                                        </tr>
                                        </tfoot>

                                    </table>

                                </div>
                            </div></div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="float-right" id="dynamic-table_paginate">
                                    {{$withdraws->appends(request()->query())->links()}}
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


