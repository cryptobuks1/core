@extends('frontend.'.$current_theme.'.app')

@section('meta-tags')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('customstyle')
    <link rel="stylesheet" href="{{ theme_asset('css/softcard.css') }}" type="text/css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('breadcrumbs', Breadcrumbs::render('default','Mua mã thẻ'))

@section('content')
    @theme_include('errors.errors')

    @if(Auth::check())

    <h4><span class="text-uppercase">Lịch sử mua mã thẻ</span></h4>
    <div class="blockContent">
        <div class="card">
            <div class="card-body" style="padding-bottom: 10px;">
                <form action="" name="formSearch" method="GET" class="form-inline">
                    <div class="form-group">

                        <select name="status" class="form-control" style="padding: 0px">

                            <option value="" @if(app("request")->input("status")== "") selected="selected" @endif>-- Trạng thái --</option>
                            <option value="completed" @if(app("request")->input("status")== "completed") selected="selected" @endif>Thành công</option>
                            <option value="canceled" @if(app("request")->input("status")== "canceled") selected="selected" @endif>Hủy bỏ</option>
                            <option value="pending" @if(app("request")->input("status")== "pending") selected="selected" @endif>Chờ xử lý</option>
                            <option value="none" @if(app("request")->input("status")== "none") selected="selected" @endif>Nháp</option>

                        </select>
                        <input class="form-control" value="@if(app("request")->input("fromdate")){{app("request")->input("fromdate")}}@else{{date('d-m-Y', time())}}@endif" name="fromdate" id="datepicker">
                        <input class="form-control" value="@if(app("request")->input("todate")){{app("request")->input("todate")}}@else{{date('d-m-Y', time())}}@endif" name="todate" id="datepicker2">

                        <button type="submit" name="submit" value="filter" class="btn btn-success btn-sm"><i class="fa fa-search"></i> Lọc dữ liệu</button>
                        <button type="submit" name="submit" value="excel" class="btn btn-warning btn-sm"><i class="fa fa-download"></i> Xuất Excel</button>

                    </div>
                </form>
            </div>
                <div class="row"><div class="col-sm-12 table-responsive">
                        <table id="example1" class="table table-bordered table-striped dataTable">
                            <thead>
                            <tr>
                                <th>Mã giao dịch</th>
                                <th>Sản phẩm</th>
                                <th>TT thanh toán</th>
                                <th>TT đơn hàng</th>
                                <th>Số tiền</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($orders_softcard) > 0)
                                @foreach( $orders_softcard as $softcard )
                                    <tr>
                                        <td>{{$softcard->order_code}}
                                            <br>
                                            <span class="text-muted">{{$softcard->request_id}}</span></td>
                                        <td>
                                            {!! App\Modules\Order\Models\Order::getlistproduct($softcard) !!}
                                        </td>
                                        <td>

                                            @if($softcard->payment == 'paid')
                                                <span class="label label-success">ĐÃ THANH TOÁN</span>
                                            @elseif($softcard->payment == 'unpaid')
                                                <span class="label label-warning">CHƯA THANH TOÁN</span>
                                            @elseif($softcard->payment == 'refunded')
                                                <span class="label label-primary">ĐÃ HOÀN TIỀN</span>
                                            @elseif($softcard->payment == 'none')
                                                <span class="label label-default">NHÁP</span>
                                            @elseif($softcard->payment == 'canceled')
                                                <span class="label label-danger">ĐÃ HỦY</span>
                                            @else
                                                <span class="label label-default">CHƯA RÕ</span>
                                            @endif

                                        </td>
                                        <td>

                                            @if($softcard->status == 'completed')
                                                <span class="label label-success">HOÀN THÀNH</span>
                                            @elseif($softcard->status == 'pending')
                                                <span class="label label-warning">CHỜ XỬ LÝ</span>
                                            @elseif($softcard->status == 'none')
                                                <span class="label label-default">NHÁP</span>
                                            @elseif($softcard->status == 'canceled')
                                                <span class="label label-danger">ĐÃ HỦY</span>
                                            @else
                                                <span class="label label-default">CHƯA RÕ</span>
                                            @endif

                                        </td>
                                        <td>{{number_format($softcard->pay_amount)}} {{$softcard->currency_code}}</td>

                                        <td>{{date('d-m-Y H:i', strtotime($softcard->created_at))}}</td>

                                        <td>

                                            <a href="{{url('/softcard/detail/'.$softcard->order_code)}}"><button type="submit" class="btn btn-info btn-xs" value="delete">Xem đơn</button></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            @if(isset($total))
                            <tr>
                                <td colspan="3"></td>
                                <td><strong>Tổng số</strong></td>
                                <td><strong>{{number_format($total->sum('pay_amount'))}}</strong></td>
                                <td colspan="2"></td>

                            </tr>
                            @endif
                        </table>
                        {{$orders_softcard->appends(request()->query())->links()}}

                    </div>
                </div>


        </div>
    </div>


@endif

@endsection

@section('js-footer')
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