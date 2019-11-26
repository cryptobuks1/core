@extends('frontend.'.$current_theme.'.app')
@section('breadcrumbs', Breadcrumbs::render('depositwallet'))
@section('content')
    @theme_include('errors.errors')
    <section class="row">
        <div class="col-md-6">
            <h4><span class="text-uppercase">Tạo yêu cầu nạp tiền</span></h4>

            {!! Form::open(array('route' => 'frontend.wallet.deposit','method'=>'POST')) !!}
                    <div class="form-group">
                        <label for="FormControlSelect">Chọn ví muốn nạp</label>
                        <select name="wallet" class="form-control" style="padding: 0px">
                            @if(count($listwallets)>0)
                                @foreach($listwallets as $wallet)
                                    <option value="{{$wallet->number}}">{{$wallet->number}}
                                        ( {{number_format($wallet->balance_decode)}} {{$wallet->currency_code}} )
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="net_amount">Số tiền muốn nạp:</label>
                        <input name="net_amount" type="text" class="form-control" id="net_amount" placeholder="Số tiền"
                               value="{{ old('net_amount') }}">
                    </div>

                    <div class="form-group">
                        {!! $paygates !!}
                    </div>


            <div class="card-footer">
                <button type="submit" class="btn btn-lg btn-primary">Nạp tiền ngay</button>
            </div>
            {!! Form::close() !!}

        </div>
        <div class="col-md-6">
            <fieldset>
                <legend><h4><span class="text-uppercase">Thông báo</span></h4></legend>
                <div class="JustifyLeft text-danger">
                    @if(count($fees) > 0)
                        @foreach($fees as $fee_i)
                    {{$fee_i->deposit_info}}
                        @endforeach
                        @endif
                </div>
            </fieldset>
            <br>
            @if(count($fees) > 0)
            <h4><span class="text-uppercase">Giới hạn</span></h4>
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
                    <td>Tổng <strong class="text-success">NẠP</strong> tối đa trong ngày</td>
                    @foreach($fees as $fee)
                    <td>{{ ($fee->total_daily_deposit[$group]) ? number_format($fee->total_daily_deposit[$group])." ".$fee->currency_code : 'Không giới hạn' }}</td>
                    @endforeach
                </tr>
                </tbody>
            </table>
                @endif

        </div>

        <div class="col-md-12 table-responsive">
            <br>
            <h4><span class="text-uppercase">Lịch sử đơn hàng nạp tiền</span></h4>

            <table class="table table-bordered table-striped dataTable">
                <thead>
                <tr>

                    <th>Mã GD</th>
                    <th>Nạp vào ví</th>
                    <th>Số tiền</th>
                    <th>Hình thức</th>
                    <th>Ngân hàng nhận</th>
                    <th>Ngày tạo</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tbody>
                @if(count($deposits)>0)
                    @foreach( $deposits as $deposit )
                        <tr>

                            <td>{{$deposit->order_code}}<br></td>
                            <td>{{$deposit->payee_wallet}}</td>
                            <td>+{{number_format($deposit->net_amount)}} {{$deposit->currency_code}}</td>
                            <td>{{$deposit->bank_code}}</td>
                            <td>
                                @if(isset($deposit->bank_info) && $deposit->bank_info)
                                    <span><strong>{{$deposit->bank_info->name}}</strong></span><br>
                                    @if($deposit->bank_info->acc_num)
                                        <span>STK: <strong>{{$deposit->bank_info->acc_num}}</strong></span><br>
                                    @endif
                                    @if($deposit->bank_info->card_num)
                                    <span>Số thẻ ATM: <strong>{{$deposit->bank_info->card_num}}</strong></span><br>
                                    @endif
                                    <span>CTK: <strong>{{$deposit->bank_info->acc_name}}</strong></span><br>
                                    <span>Chi nhánh: {{$deposit->bank_info->branch}}</span><br>
                                @endif
                            </td>
                            <td>{{$deposit->created_at}}</td>
                            <td>
                                @if($deposit->status == 'completed')
                                    <span class="label label-success">HOÀN THÀNH</span>
                                @elseif($deposit->status == 'pending')
                                    <span class="label label-warning">CHỜ XỬ LÝ</span>
                                @elseif($deposit->status == 'none')
                                    <span class="label label-default">ĐỢI THANH TOÁN</span>
                                @elseif($deposit->status == 'canceled')
                                    <span class="label label-danger">ĐÃ HỦY</span>
                                @endif
                            </td>
                            <td>
                                @if($deposit->link)
                                    <a href="{{$deposit->link}}">
                                        <button class="btn btn-info btn-sm">Xem</button>
                                    </a>
                                @endif
                                    @if($deposit->payment == 'none')
                                    <a href="{{route('frontend.wallet.canceldeposit', $deposit->order_code)}}">
                                        <button class="btn btn-danger btn-sm">Hủy</button>
                                    </a>
                                    @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
            {{$deposits->links()}}

        </div>
    </section>




@endsection
