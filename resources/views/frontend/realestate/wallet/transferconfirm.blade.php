@extends('frontend.'.$current_theme.'.common')
@section('breadcrumbs', Breadcrumbs::render('transfer'))
@section('content')
    @theme_include('errors.errors')
    <section class="main">
        <div class="blockContent">
            <h4><span class="text-uppercase">Xác nhận chuyển tiền</span></h4>


            <div class="row">
                <div class=" col-md-12">
                    <table class="table">
                        <tbody>

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
                            <td>{{ number_format($order->net_amount, $currency->decimal) }} {{ $currency->symbol_right }}</td>
                        </tr>
                        <tr>
                            <td>Phí:</td>
                            <td>{{ number_format($order->fees, $currency->decimal) }} {{ $currency->symbol_right }}</td>
                        </tr>
                        <tr>
                            <td>Số tiền thanh toán:</td>
                            <td><b>{{ number_format($order->pay_amount, $currency->decimal) }} {{ $currency->symbol_right }}</b></td>
                        </tr>

                        <tr>
                            <td>Mô tả:</td>
                            <td>{{ $order->description }}

                            </td>
                        </tr>


                        </tbody>
                    </table>

                    <div class="card-footer">
                        <form action="{{route('post.confirm.wallet.transfer')}}" method="POST">

                            <table class="table">
                                <tbody>


                                <td width="50%">

                                        <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                                        <script src='https://www.google.com/recaptcha/api.js'></script>
                                </td>

                                <td width="50%">
                                    {!! $twofactor !!}

                                </td>
                                </tr>

                                </tbody>
                            </table>

                            <input name="order_id" value="{{$order->id}}" type="hidden">
                            <input name="cs" value="{{$order->checksum}}" type="hidden">
                            <input name="tk" value="{{$order->token}}" type="hidden">
                            <input name="action" value="doPayment" type="hidden">
                            <button type="submit" class="btn btn-primary" onclick="this.disabled=true;this.value='Đang thực hiện...';this.form.submit();">Xác nhận chuyển tiền</button>
                            {{ csrf_field() }}
                        </form>

                    </div>
                </div>
            </div>



        </div>
    </section>

@endsection
