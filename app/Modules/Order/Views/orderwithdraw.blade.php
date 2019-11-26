@extends('master')

@section('css')
@endsection

@section('js')

    <script>
        $(document).ready(function () {
            $(".edit-withdraw-btn").click(function () {
                var id = $(this).attr('data-id');
                $.get("{{url($backendUrl)}}/ajax/withdraw/" + id, function (data) {
                    $("#WithdrawAjaxContent").html(data);
                });
                $("#WithdrawModal").modal();
                return false;
            });
        });
    </script>


@endsection

@section('content')

    <style>
        .modal-dialog {
            max-width: 1000px;
            margin: 1.75rem auto;
        }
    </style>
    <div class="modal fade" id="WithdrawModal" tabindex="-1" role="dialog" aria-labelledby="WithdrawModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div id="WithdrawAjaxContent"></div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card">

                    <div class="card-header" style="border-bottom: 0">

                        <div class="row">
                            <div class="col-md-7">
                                <h3 class="card-title">Danh sách</h3>
                            </div>
                            <div class="col-md-5">
                                <div class="card-tools float-right">
                                    <div class="input-group">
                                        <form action="" name="formSearch" method="GET">
                                            <div class="input-group">
                                                <select name="type" class="form-control" style="">
                                                    <option value="order_code"
                                                            @if(app("request")->input("type")=="order_code") selected="selected" @endif>
                                                        Mã đơn hàng
                                                    </option>
                                                    <option value="email"
                                                            @if(app("request")->input("type")=="email") selected="selected" @endif>
                                                        Email
                                                    </option>
                                                    <option value="statuspending"
                                                            @if(app("request")->input("type")=="statuspending") selected="selected" @endif>
                                                        Chờ xử lý
                                                    </option>
                                                    <option value="phone"
                                                            @if(app("request")->input("type")=="phone") selected="selected" @endif>
                                                        Điện thoại
                                                    </option>

                                                </select>
                                                <input type="text" name="keyword" class="form-control"
                                                       placeholder="Search"
                                                       value="{{ app("request")->input("keyword") }}"/>
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-warning"><i
                                                                class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <form action="{{ url($backendUrl.'/orders/actions') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-body" style="padding-top: 0;">
                            <div class="row table-responsive">
                                <div class="col-sm-12">
                                    <table id="tablez" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Mã</th>
                                            <th>Khách hàng</th>
                                            <th>Ví</th>
                                            <th>Số tiền rút</th>
                                            <th>Số dư ví hiện tại</th>
                                            <th>Tài khoản nhận</th>
                                            <th>Thanh toán</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th>Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach( $orders as $order )
                                            <tr class="irow" data-id="">
                                                <td>{{ $order->order_code }}</td>
                                                <td>{!! App\User::getUserInfo($order->payer_id) !!}</td>
                                                <td>{{ $order->payer_wallet }}</td>
                                                <td>{{ number_format($order->net_amount) }} {{$order->currency_code}}</td>
                                                <td>
                                                    <strong>{{ number_format($order->balance) }} {{$order->currency_code}}</strong><br>
                                                    <a class="wallethis" data-toggle="modal"
                                                       data-target="#ViewWalletHis" data-id="{{$order->payer_id}}"
                                                       href="#">Xem lịch sử</a>
                                                </td>
                                                <td>
                                                    {!! $order->payer_info !!}
                                                </td>
                                                <td>
                                                    @if($order->payment == 'paid')
                                                        <label class="badge badge-success">ĐÃ THANH TOÁN</label>
                                                    @elseif($order->payment == 'unpaid')
                                                        <label class="badge badge-warning">CHƯA THANH TOÁN</label>
                                                    @elseif($order->payment == 'none')
                                                        <label class="badge badge-dark">NHÁP</label>
                                                    @elseif($order->payment == 'refunded')
                                                        <label class="badge badge-dark">ĐÃ HOÀN TIỀN</label>
                                                    @elseif($order->payment == 'canceled')
                                                        <label class="badge badge-danger">HỦY BỎ</label>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($order->status == 'completed')
                                                        <label class="badge badge-success">HOÀN THÀNH</label>
                                                    @elseif($order->status == 'pending')
                                                        <label class="badge badge-warning">ĐỢI CHUYỂN</label>
                                                    @elseif($order->status == 'none')
                                                        <label class="badge badge-dark">NHÁP</label>
                                                    @elseif($order->status == 'canceled')
                                                        <label class="badge badge-danger">BỊ HỦY</label>
                                                    @endif
                                                </td>
                                                <td>{{ $order->created_at }}</td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <span class=" btn btn-success edit-withdraw-btn btn-sm"
                                                              data-id="{{ $order->id }}"><span>Xử lý</span></span>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>


                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <select name="action" class="form-control">
                                                    <option value=""></option>
                                                    <option value="on">Bật đã chọn</option>
                                                    <option value="off">Tắt đã chọn</option>
                                                    <option value="delete">Xóa đã chọn</option>
                                                </select>

                                            </div>
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-warning"><i
                                                            class="ace-icon fa fa-check-circle bigger-130"></i> Thực
                                                    hiện
                                                </button>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="float-right" id="dynamic-table_paginate">
                                        <?php $orders->setPath('wallet/orderwithdraw'); ?>
                                        <?php echo $orders->render(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>


                    <!-- End Delete form-->


                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

    <!-- Modal -->
    <div class="modal fade" id="ViewWalletHis" tabindex="-1" role="dialog" aria-labelledby="ViewWalletHisLable"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ViewWalletHisLable">10 giao dịch gần nhất</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="walletlisthistory">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $(".wallethis").click(function () {
                var id = $(this).attr('data-id');
                $.get("{{url($backendUrl)}}/ajax/wallethistory/" + id, function (data) {
                    $("#walletlisthistory").html(data);
                });
            });
        });
    </script>

    <!-- /.content -->
@endsection
