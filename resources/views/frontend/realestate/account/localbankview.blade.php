@extends('frontend.'.$current_theme.'.common')
@section('breadcrumbs', Breadcrumbs::render('localbank'))
@section('content')
    @theme_include('errors.errors')
    <h4><span class="text-uppercase">Thanh toán chuyển khoản</span></h4>
    <span class="text-uppercase">Vui lòng thanh toán cho đơn hàng sau</span>
    <table class="table table-bordered table-striped dataTable">
        <thead>
        <tr>
            <th>Mã GD</th>
            <th>Số tiền</th>
            <th>Tài khoản thụ hưởng</th>
            <th>Ngày tạo</th>
            <th>Nội dung</th>
            <th>Trạng thái</th>
        </tr>
        </thead>
        <tbody>

            <tr>
                <td>{{$wallet_order->order_code}}</td>
                <td>+{{number_format($wallet_order->net_amount)}} {{$wallet_order->currency_code}}</td>
                <td>
                    @if($wallet_order->bankinfo)
                        @php $wallet_order = json_decode($wallet_order->bankinfo); @endphp
                        {!! $wallet_order->name . ' '. $wallet_order->branch. '<br> STK:'. $wallet_order->acc_num .'<br>CTK:'. $wallet_order->acc_name !!}
                    @endif
                </td>
                <td>{{date('d-m-Y H:i', strtotime($deposit->created_at))}}</td>
                <td>Thanh toan don hang {{$wallet_order->order_code}}</td>
                <td>
                    <span class="label label-warning">{{$wallet_order->status}}</span>
                </td>


        </tbody>


    </table>
@endsection
