@extends('master')

@section('css')
@endsection

@section('js')

    <script>
        $(document).ready(function(){
            $(".edit-deposit-btn").click(function(){
                var id = $(this).attr('data-id');
                $.get( "{{url($backendUrl)}}/ajax/deposit/"+id, function( data ) {
                    $( "#DepositAjaxContent" ).html( data );
                });
                $("#DepositModal").modal();
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
    <div class="modal fade" id="DepositModal" tabindex="-1" role="dialog" aria-labelledby="DepositModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div id="DepositAjaxContent"></div>
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
                                <a href="{{ url($backendUrl.'/wallet/orderdeposit') }}"><button class="btn btn-info"><i class="fa fa-home"></i> Home</button></a>
                                <a href="{{ url($backendUrl.'/statistic/deposit') }}"><button class="btn btn-success"><i class="fa fa-database"></i> Thống kê</button></a>
                            </div>
                            <div class="col-md-5">

                                <div class="card-tools float-right">
                                    <div class="input-group">
                                        <form action="" name="formSearch" method="GET" >
                                            <div class="input-group">
                                                <select name="type" class="form-control" style="">
                                                    <option value="order_code" @if(app("request")->input("type")=="order_code") selected="selected" @endif>Mã đơn hàng</option>
                                                    <option value="email" @if(app("request")->input("email")=="email") selected="selected" @endif>Email</option>
                                                    <option value="phone" @if(app("request")->input("phone")=="phone") selected="selected" @endif>Điện thoại</option>

                                                </select>
                                                <input type="text" name="keyword" class="form-control" placeholder="Search" value="{{ app("request")->input("keyword") }}" />
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- /.card-header -->
                    <form action="{{ url($backendUrl.'/orders/action') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-body" style="padding-top: 0;">
                            <div class="row table-responsive"><div class="col-sm-12">
                                    <table id="tablez" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="center sorting_disabled" rowspan="1" colspan="1" aria-label="">
                                                <label class="pos-rel">
                                                    <input type="checkbox" class="ace" id="checkall">
                                                    <span class="lbl"></span> </label>
                                            </th>
                                            <th>Mã</th>
                                            <th>Khách hàng</th>
                                            <th>Nạp vào ví</th>
                                            <th>Số tiền</th>
                                            <th>Tài khoản</th>
                                            <th>Thanh toán</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th>Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach( $orders as $order )
                                            <tr class="irow" data-id="{{ $order->id }}">

                                                <td class="center"><label class="pos-rel">
                                                        <input type="checkbox" class="ace mycheckbox" value="{{ $order->id }}" name="check[]">
                                                        <span class="lbl"></span> </label>
                                                </td>
                                                <td>{{ $order->order_code }}</td>
                                                <td>{!! App\User::getUserInfo($order->payee_id) !!}</td>
                                                <td>{{ $order->payee_wallet }}</td>
                                                <td>{{ number_format($order->net_amount) }} VND</td>
                                                <td>
                                                    {!! $order->payment_acc !!}
                                                </td>
                                                <td>
                                                    @if($order->payment == 'paid')
                                                        <label class="badge badge-success">ĐÃ THANH TOÁN</label>
                                                    @elseif($order->payment == 'unpaid')
                                                        <label class="badge badge-warning">CHƯA THANH TOÁN</label>
                                                    @elseif($order->payment == 'none')
                                                        <label class="badge badge-dark">CHỜ THANH TOÁN</label>
                                                    @elseif($order->payment == 'canceled')
                                                        <label class="badge badge-danger">HỦY BỎ</label>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($order->status == 'completed')
                                                        <label class="badge badge-success">HOÀN THÀNH</label>
                                                    @elseif($order->status == 'pending')
                                                        <label class="badge badge-warning">CHỜ XỬ LÝ</label>
                                                    @elseif($order->status == 'none')
                                                        <label class="badge badge-dark">ĐỢI</label>
                                                    @elseif($order->status == 'canceled')
                                                        <label class="badge badge-danger">BỊ HỦY</label>
                                                    @endif
                                                </td>
                                                <td>{{ $order->created_at }}</td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <span class=" btn btn-success edit-deposit-btn btn-sm" data-id="{{ $order->id }}"><span>Xử lý</span></span>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>


                                    </table>
                                </div></div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <select name="action" class="form-control">
                                                    <option value="">-- Hành động --</option>
                                                    <option value="delete">Xóa đã chọn</option>
                                                </select>

                                            </div>
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-warning"><i class="ace-icon fa fa-check-circle bigger-130"></i> Thực hiện</button>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="float-right" id="dynamic-table_paginate">
                                        <?php $orders->setPath('wallet/orderdeposit'); ?>
                                        <?php echo $orders->render(); ?>
                                    </div>
                                </div>
                            </div>
                        </div></form>

                    <!-- Delete form -->
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $(".deleteClick").click(function(){
                                var link = $(this).attr('link');
                                var name = $(this).attr('name');
                                $("#deleteForm").attr('action',link);
                                $("#deleteMes").html("Delete : "+name+" ?");
                            });
                        });
                    </script>

                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form id="deleteForm" action="" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div id="deleteMes" class="modal-body">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    <input type="hidden" name="_method" value="delete" />
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                    </div>
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
