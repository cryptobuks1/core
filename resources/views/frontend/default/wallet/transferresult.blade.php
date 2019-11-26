@extends('frontend.'.$current_theme.'.common')
@section('breadcrumbs', Breadcrumbs::render('transfer'))
@section('content')
    @theme_include('errors.errors')
    <section class="main">
        <div class="blockContent">
            <h4><span class="text-uppercase">Kết quả chuyển tiền</span></h4>


            <div class="row">
                <div class=" col-md-12">
                    <table class="table">
                        <tbody>

                        <tr>
                            <td>Mã giao dịch:</td>
                            <td>{{ $order->order_code }}
                            </td>
                        </tr>
                        <tr>
                            <td>Tài khoản người nhận:</td>
                            <td>{{ $order->payee_info }}
                            </td>
                        </tr>
                        <tr>
                            <td>Tên người nhận:</td>
                            <td>{{ $user->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Ví người nhận:</td>
                            <td>{{ $order->payee_wallet }}
                            </td>
                        </tr>
                        <tr>
                            <td>Số tiền:</td>
                            <td><strong>{{ number_format($order->net_amount) }} {{ $order->currency_code }}</strong></td>
                        </tr>
                        <tr>
                            <td>Mô tả:</td>
                            <td>{{ $order->description }}

                            </td>
                        </tr>

                        <tr>
                            <td>Trạng thái:</td>
                            <td>

                                @if($order->status == 'completed')
                                    <span class="label label-success">HOÀN THÀNH</span>
                                @elseif($order->status == 'pending')
                                    <span class="label label-warning">CHỜ XỬ LÝ</span>
                                @elseif($order->status == 'none')
                                    <span class="label label-default">NHÁP</span>
                                @elseif($order->status == 'canceled')
                                    <span class="label label-danger">ĐÃ HỦY</span>
                                @else
                                    <span class="label label-default">CHƯA RÕ</span>
                                @endif

                            </td>
                        </tr>

                        </tbody>
                    </table>

                </div>
            </div>


            <h4><span class="text-uppercase">Lịch sử gửi tiền</span></h4>

            <div class="card">
                <div class="card-body" style="padding-top: 0;">
                    <div class="row table-responsive">
                        <div class="col-sm-12">
                            <table id="example1" class="table table-bordered table-striped dataTable">
                                <thead>
                                <tr>
                                    <th>Mã GD</th>
                                    {{--<th>Người gửi</th>--}}
                                    <th>Người nhận</th>
                                    <th>Số tiền</th>
                                    <th>Phí</th>
                                    <th>Ngày tạo</th>
                                    <th>Nội dung giao dịch</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($trans) > 0)
                                    @foreach( $trans as $tran )
                                        <tr>
                                            <td>{{$tran->order_code}}</td>
                                            {{--<td>{!! \App\Modules\Order\Models\Order::getUserInfo_short($tran->payer_id) !!}</td>--}}
                                            <td>{!! \App\Modules\Order\Models\Order::getUserInfo_short($tran->payee_id) !!}</td>
                                            <td>
                                                <b>@if($tran->payer_id == $login_user_id) <span class="text-danger">-{{number_format($tran->pay_amount)}} {{$tran->currency_code}}</span>@else <span class="text-success">+{{number_format($tran->net_amount)}} {{$tran->currency_code}}</span> @endif </b></span>
                                            </td>
                                            <td>@if($tran->payer_id == $login_user_id){{number_format($tran->fees)}} {{$tran->currency_code}}@endif</td>
                                            <td>{{date('d-m-Y H:i:s', strtotime($tran->created_at))}}</td>
                                            <td>{{$tran->description}}</td>

                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>


                            </table>

                            {{ $trans->links() }}
                        </div>
                    </div>
                </div>

            </div>



        </div>
    </section>

@endsection
