@extends('frontend.'.$current_theme.'.common93')
@section('breadcrumbs', Breadcrumbs::render('withdrawwallet'))
@section('content')
    @theme_include('errors.errors')
    <section class="main">
        <div class="blockContent">
            <h4><span class="text-uppercase">Xác nhận rút tiền</span></h4>

            <div class="row">
                <div class=" col-md-12">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Ví muốn rút:</td>
                            <td>{{ $wallet->number }}
                            </td>
                        </tr>
                        <tr>
                            <td>Số dư hiện tại:</td>
                            <td>{{ number_format($wallet->balance_decode) }} {{ $wallet->currency_code }}</td>
                        </tr>
                        <tr>
                            <td>Số tiền muốn rút:</td>
                            <td>{{ number_format($order->net_amount) }} {{ $wallet->currency_code }}

                            </td>
                        </tr>

                        <tr>
                            <td>Phí:</td>
                            <td>{{number_format($order->fees)}} {{ $wallet->currency_code }}</td>
                        </tr>
                        <tr>
                            <td>Số tiền thanh toán:</td>
                            <td><b>{{ number_format($order->pay_amount) }} {{ $wallet->currency_code }}</b></td>
                        </tr>
                        <tr>
                            <td>Mô tả:</td>
                            <td>{{ $order->description }}
                            </td>
                        </tr>
                        <tr>
                            <td>Tài khoản nhận thanh toán:</td>
                              <td>  {!! $order->payer_info !!}
                            </td>
                        </tr>


                        </tbody>
                    </table>

                    <div class="card-footer">
                        <form action="{{$actionUrl}}" method="POST">

                            {!! $twofactor !!}
                            <br>
                            <input name="order_id" value="{{$order->id}}" type="hidden">
                            <input name="action" value="doPayment" type="hidden">
                            <button type="submit" class="btn btn-primary" onclick="this.disabled=true;this.value='Đang thực hiện...';this.form.submit();">Xác nhận rút tiền</button>
                            {{ csrf_field() }}
                        </form>

                    </div>
                </div>
            </div>




        </div>
    </section>

@endsection
