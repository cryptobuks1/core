@extends('frontend.'.$current_theme.'.app')
@section('breadcrumbs', Breadcrumbs::render('checkout'))

@section('content')
    @theme_include('errors.errors')
    <div class="row">
    <div class="col-md-8">
        <h4><span class="text-uppercase">Thông tin đơn hàng</span></h4>

        {!! $cart !!}

    </div>
    <div class="col-md-4">
        <h4><span class="text-uppercase">Thông tin thanh toán</span></h4>
        <table class="table table-bordered table-striped dataTable">
            <tbody>
                <tr>
                    <td>Thành tiền</td>
                    <td>{{number_format($order->net_amount)}} {{$order->currency_code}}</td>
                </tr>
                <tr>
                    <td>Phí</td>
                    <td>{{number_format($order->fees)}} {{$order->currency_code}}</td>
                </tr>
                <tr>
                    <td>Tổng số</td>
                    <td><strong class="text-danger">{{number_format($order->pay_amount)}} {{$order->currency_code}}</strong></td>
                </tr>
                <tr>
                    <td>Cổng thanh toán</td>
                    <td>{{($order->bank_code) ? $order->bank_code : $order->paygate_code}}</td>
                </tr>
            </tbody>
        </table>

        <form action="{{ $actionUrl }}" method="POST">
            {{ csrf_field() }}

            @if($twofactor !== null)
                {!! $twofactor !!}
                <br>
            @endif

            <input type="hidden" name="action" value="doPayment">
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <button type="submit" class="btn btn-lg btn-warning btn-block">Thanh toán ngay <i class="fa fa-angle-right"></i></button>
        </form>
    </div>
    </div>
@endsection
