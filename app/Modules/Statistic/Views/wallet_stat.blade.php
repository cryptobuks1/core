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

                                        <select name="code" class="form-control" style="">
                                            <option value="" @if(app("request")->input("code")== "") selected="selected" @endif>-- Loại --</option>
                                            <option value="C" @if(app("request")->input("code")== 'C') selected="selected" @endif>Đổi thẻ cào</option>
                                            <option value="S" @if(app("request")->input("code")== 'S') selected="selected" @endif>Mua thẻ cào</option>
                                            <option value="M" @if(app("request")->input("code")== 'M') selected="selected" @endif>Nạp cước</option>
                                            <option value="W" @if(app("request")->input("code")== 'W') selected="selected" @endif>Rút tiền từ ví</option>
                                            <option value="D" @if(app("request")->input("code")== 'D') selected="selected" @endif>Nạp tiền vào ví</option>

                                        </select>

                                        <input class="form-control" value="@if(app("request")->input("fromdate")){{ trim(app("request")->input("fromdate"))}}@else{{ trim(date('d-m-Y', time()))}}@endif" name="fromdate" id="datepicker">
                                        <input class="form-control" value="@if(app("request")->input("todate")){{ trim(app("request")->input("todate"))}}@else{{ trim(date('d-m-Y', time()))}}@endif" name="todate" id="datepicker2">

                                        <select name="currency_id" class="form-control" style="">
                                            <option value="" @if(app("request")->input("currency_id")== "") selected="selected" @endif>-- Tiền tệ --</option>
                                            @if($currencies && count($currencies) > 0)
                                                @foreach($currencies as $key => $currency)
                                                <option value="{{$key}}" @if(app("request")->input("currency_id")== $key) selected="selected" @endif>{{$currency}}</option>
                                                @endforeach
                                            @endif

                                        </select>

                                        <input class="form-control" @if(app("request")->input("user_id")) value="{{trim(app("request")->input("user_id"))}}" @else value="1" @endif name="user_id" placeholder="Mã khách hàng">

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
                                            <th>Số dư trước GD</th>
                                            <th>Số tiền NET</th>
                                            <th>Phí</th>
                                            <th>Số thanh toán</th>
                                            <th>Số dư sau GD</th>
                                            <th>Tiền tệ</th>
                                            <th>Mã khách hàng</th>
                                            <th>Ngày tạo</th>
                                            <th>Mô tả</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(!count($wallets))
                                            <tr>
                                                <td colspan="11" class="text-center alert alert-info">Chưa có dữ liệu</td>
                                            </tr>
                                        @else

                                            @foreach( $wallets as $w_order )
                                                <tr>
                                                    <td>{{ $w_order->order_code }}</td>
                                                    <td>{!! App\User::getUserInfo($w_order->user_id) !!}</td>
                                                    <td>{{ number_format($w_order->before_balance) }}</td>
                                                    <td>{{ number_format($w_order->net_amount) }}</td>
                                                    <td>{{ number_format($w_order->fees) }}</td>
                                                    <td>{{ number_format($w_order->pay_amount) }}</td>
                                                    <td>{{ number_format($w_order->after_balance) }}</td>
                                                    <td>{{$w_order->currency_code }}</td>
                                                    <td>{{ $w_order->user_id }}</td>
                                                    <td>{{ $w_order->created_at }}</td>
                                                    <td><input value="{{ $w_order->description }}"></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot>

                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>

                                            <th>{{ number_format($total->sum('net_amount')) }}</th>
                                            <th>{{ number_format($total->sum('fees')) }}</th>
                                            <th>{{ number_format($total->sum('pay_amount')) }}</th>
                                            <th></th>
                                            <th colspan="5"></th>

                                        </tr>
                                        </tfoot>

                                    </table>

                                </div>
                            </div></div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="float-right" id="dynamic-table_paginate">
                                    {{$wallets->appends(request()->query())->links()}}
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


