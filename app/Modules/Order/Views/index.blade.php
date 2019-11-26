@extends('master')

@section('css')
@endsection

@section('js')

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card">

                    <div class="card-header" style="border-bottom: 0">
                        <h3 class="card-title">Danh sách các loại</h3>

                    </div>
                    <!-- /.card-header -->
                    <form action="{{ url($backendUrl.'/orders/action') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-body" style="padding-top: 0;">
                            <div class="row"><div class="col-sm-12">
                                    <table id="tablez" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Mã ĐH</th>
                                            <th>Mô tả</th>
                                            <th>Trạng thái</th>
                                            <th>Loại</th>
                                            <th>Khách hàng</th>
                                            <th>Số tiền</th>
                                            <th>Tiền tệ</th>
                                            <th>Cổng TT</th>
                                            <th>Giao dịch</th>
                                            <th>Ngày tạo</th>
                                            <th>Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach( $orders as $order )
                                            <tr class="irow" data-id="{{ $order->id }}">
                                                <td class="center"><span class="text-success">{{ $order->order_code }}</span></td>
                                                <td class="center"><textarea>{{ $order->description }}</textarea></td>
                                                <td>
                                                    @if($order->status == 'completed')
                                                        <label class="badge badge-success">HOÀN THÀNH</label>
                                                    @elseif($order->status == 'pending')
                                                        <label class="badge badge-warning">CHỜ XỬ LÝ</label>
                                                    @elseif($order->status == 'none')
                                                        <label class="badge badge-secondary">NHÁP</label>
                                                    @elseif($order->status == 'canceled')
                                                        <label class="badge badge-danger">ĐÃ HỦY</label>
                                                    @else
                                                        <label class="badge badge-dark">CHƯA RÕ</label>
                                                    @endif
                                                </td>
                                                <td>{{ $order->module }}</td>
                                                <td>{!! App\User::getUserInfo($order->payer_id) !!}</td>
                                                <td>{{ number_format($order->net_amount) }} {{ $order->currency_code }}</td>
                                                <td>{{ $order->currency_code }}</td>
                                                <td>{{ $order->paygate_code }}</td>
                                                <td>

                                                    @if($order->payment == 'paid')
                                                        <label class="badge badge-success">ĐÃ THANH TOÁN</label>
                                                    @elseif($order->payment == 'unpaid')
                                                        <label class="badge badge-warning">CHƯA THANH TOÁN</label>
                                                    @elseif($order->payment == 'none')
                                                        <label class="badge badge-secondary">NHÁP</label>
                                                    @elseif($order->payment == 'refunded')
                                                        <label class="badge badge-primary">ĐÃ HOÀN TIỀN</label>
                                                    @elseif($order->payment == 'canceled')
                                                        <label class="badge badge-danger">ĐÃ HỦY</label>
                                                    @else
                                                        <label class="badge badge-dark">CHƯA RÕ</label>
                                                    @endif

                                                </td>
                                                <td>{{ $order->created_at }}</td>
                                                <td>
                                                    <div class="action-buttons">
                                                      <a href="#" data-id ="{{$order->id}}" name="{{$order->order_code}}" link="{{ url($backendUrl.'/order/'.$order->id.'/delete') }}" class="deleteClick red id-btn-dialog2" data-toggle="modal" data-target="#deleteModal" > <button class="btn btn-danger btn-sm">Xóa</button></a>

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
                                                    <option value=""></option>
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
                                        <?php $orders->setPath('orders'); ?>
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
                                var order = $(this).attr('name');
                                var id = $(this).attr('data-id');
                                $("#deleteForm").attr('action',link);
                                $("#itemid").attr('value',id);
                                $("#deleteMes").html("Xóa đơn hàng: "+order+" ?");
                            });
                        });
                    </script>

                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form id="deleteForm" action="" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Xóa đơn hàng</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div id="deleteMes" class="modal-body">

                                    </div>
                                    <div class="modal-footer">

                                        <input type="hidden" id="itemid" name="id" value="" />
                                        {{ csrf_field() }}
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary">Đồng ý xóa</button>
                                    </div>

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
