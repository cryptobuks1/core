@extends('frontend.'.$current_theme.'.app')
@section('breadcrumbs', Breadcrumbs::render('transfer'))
@section('content')

    @theme_include('errors.errors')
    <section class="row">
        <div class=" col-md-7">
            <h4><span class="text-uppercase">Chuyển số dư</span></h4>
            <form action="{{route('post.wallet.transfer')}}" method="POST">
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <td>Chọn tài khoản nguồn:</td>
                        <td><select id="wallet-num" name="payer_wallet" class="form-control getWalletAjax"
                                    style="padding: 0px">
                                @foreach($listWallet as $wallet)
                                    <option value="{{$wallet->number}}">Ví {{$wallet->number}}
                                        - {{number_format($wallet->balance_decode)}} {{$wallet->currency_code}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Tài khoản nhận:</td>
                        <td><input id="get-user-wallet" type="text"
                                   placeholder="Nhập email hoặc số điện thoại hoặc username"
                                   class="form-control getWalletAjax" name="payee_info" value=""/></td>
                    </tr>

                    <tr>
                        <td>Tên người nhận:</td>
                        <td><input id="payee_name" type="text" class="form-control" name="payee_name" value="" readonly>
                        </td>
                    </tr>

                    <tr>
                        <td>Số tiền:</td>
                        <td><input type="text" class="form-control" name="amount" value="{{ old('amount') }}"
                                   placeholder="{{ (isset($cur->symbol_left)) ? $cur->symbol_left : $cur->symbol_right}}">
                        </td>
                    </tr>

                    <tr>
                        <td>Ghi chú:</td>
                        <td>
                                    <textarea name="description" id="description" class="form-control"
                                              placeholder="Nội dung">{{ old('description') }}</textarea>
                        </td>

                    </tr>
                    <tr>
                        <td></td>
                        <td>

                            <button type="submit" class="btn btn-lg btn-info">Chuyển tiền</button>

                        </td>
                    </tr>
                    </tbody>
                </table>

                {!! csrf_field() !!}

            </form>

        </div>
        <div class=" col-md-5">
            <h4><span class="text-uppercase">Phí chuyển tiền</span></h4>

            <table class="table table-bordered table-striped dataTable">
                <thead>
                <tr>
                    <th>Loại ví</th>
                    @foreach($fees as $fee)
                        <th>{{$fee->currency_code}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Phí cố định</td>
                    @foreach($fees as $fee)
                        <td>{{ ($fee->t_fixed_fees[$group]) ? number_format($fee->t_fixed_fees[$group])." ".$fee->currency_code : "0 ".$fee->currency_code }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Phí %</td>
                    @foreach($fees as $fee)
                        <td>{{ ($fee->t_percent_fees[$group]) ? number_format($fee->t_percent_fees[$group])."%" : '0%' }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Tổng <strong class="text-success">CHUYỂN</strong> tối đa trong ngày</td>
                    @foreach($fees as $fee)
                        <td>{{ ($fee->t_daily_limit[$group]) ? number_format($fee->t_daily_limit[$group])." ".$fee->currency_code : 'Không giới hạn' }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Số tiền chuyển tối thiểu</td>
                    @foreach($fees as $fee)
                        <td>{{ ($fee->t_min[$group]) ? number_format($fee->t_min[$group])." ".$fee->currency_code : 'Không giới hạn' }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Số tiền chuyển tối đa</td>
                    @foreach($fees as $fee)
                        <td>{{ ($fee->t_max[$group]) ? number_format($fee->t_max[$group])." ".$fee->currency_code : 'Không giới hạn' }}</td>
                    @endforeach
                </tr>
                </tbody>
            </table>


        </div>
        <div class="clearfix"></div>

        <div class="col-sm-12 table-responsive">
            <h4><span class="text-uppercase">Lịch sử gửi tiền</span></h4>
            <table class="table table-bordered table-striped dataTable">
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
                                <b>@if($tran->payer_id == $login_user_id) <span
                                            class="text-danger">-{{number_format($tran->pay_amount)}} {{$tran->currency_code}}</span>@else
                                        <span class="text-success">+{{number_format($tran->net_amount)}} {{$tran->currency_code}}</span> @endif
                                </b></span>
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


        <div class="col-sm-12 table-responsive">
            <h4><span class="text-uppercase">Lịch sử nhận tiền</span></h4>
            <table class="table table-bordered table-striped dataTable">
                <thead>
                <tr>
                    <th>Mã GD</th>
                    <th>Người gửi</th>
                    {{--<th>Người nhận</th>--}}
                    <th>Số tiền</th>
                    <th>Phí</th>
                    <th>Ngày tạo</th>
                    <th>Nội dung giao dịch</th>
                </tr>
                </thead>
                <tbody>
                @if(count($trans_c) > 0)
                    @foreach( $trans_c as $tran )
                        <tr>
                            <td>{{$tran->order_code}}</td>
                            <td>{!! \App\Modules\Order\Models\Order::getUserInfo_short($tran->payer_id) !!}</td>
                            {{--<td>{!! \App\Modules\Order\Models\Order::getUserInfo_short($tran->payee_id) !!}</td>--}}
                            <td>
                                <b>@if($tran->payer_id == $login_user_id) <span
                                            class="text-danger">-{{number_format($tran->pay_amount)}} {{$tran->currency_code}}</span>@else
                                        <span class="text-success">+{{number_format($tran->net_amount)}} {{$tran->currency_code}}</span> @endif
                                </b></span>
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

    </section>


    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#get-user-wallet").on('change', function (e) {
                var userinfo = $(this).val();

                $.ajax({
                    url: "{{url('transfer/ajax/get-user-name')}}",
                    method: "post",
                    data: {
                        payee_info: userinfo,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data) {
                            $("#payee_name").attr('value', data);
                        }
                    }

                });

            });


        });

    </script>


@endsection
