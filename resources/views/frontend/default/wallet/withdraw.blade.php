@extends('frontend.'.$current_theme.'.app')
@section('breadcrumbs', Breadcrumbs::render('withdrawwallet'))
@section('content')
    @theme_include('errors.errors')
    <section class="row">
        <div class="col-md-6">
            <h4><span class="text-uppercase">Tạo yêu cầu rút tiền</span></h4>

            {!! Form::open(array('route' => 'frontend.wallet.withdraw','method'=>'POST')) !!}

            <div class="form-group">
                <label for="FormControlSelect">Chọn ví muốn rút</label>
                <select name="wallet" class="form-control" style="padding: 0px">
                    @foreach($listwallets as $wallet)
                        <option value="{{$wallet->number}}">{{$wallet->number}}
                            ( {{number_format($wallet->balance_decode)}} {{$wallet->currency_code}} )
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="net_amount">Số tiền muốn rút:</label>
                <input name="net_amount" type="text" class="form-control" id="net_amount" placeholder="Số tiền"
                       value="{{ old('net_amount') }}">
            </div>

            <div class="form-group">
                <input name="paygate_code" type="hidden" value="Localhost">
                <div id="payment-render-Localbank">
                    <label>Chọn ngân hàng (Bạn cần <a href="{{url('user/localbank')}}">thêm ngân hàng</a> trước)</label>
                    <select id="paymentlist" name="bankinfo_id" class="form-control" style="padding: 0px">
                        @foreach($userbanks as $userbank)
                            <option value="{{$userbank->id}}">{!! $userbank->bankname. ' ' .$userbank->branch.' / STK: '.$userbank->acc_num.', CTK: '.$userbank->acc_name !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group" id="userbank">
            </div>

            <div class="form-group">
                <label for="description">Nội dung rút tiền:</label>
                <textarea name="description" class="form-control">{{ Auth::user()->name }} rút tiền từ ví {{$wallet->number}} ({{number_format($wallet->balance_decode)}} {{$wallet->currency_code}})</textarea>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-lg btn-warning">Rút tiền ngay</button>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="col-md-6">
            <fieldset>
                <legend><h4><span class="text-uppercase">Thông báo</span></h4></legend>
                <div class="JustifyLeft text-danger">
                    @if(count($fees) > 0)
                        @foreach($fees as $fee_i)
                            {{$fee_i->withdraw_info}}<br>
                        @endforeach
                    @endif
                </div>
            </fieldset>

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
                        <td>Tổng <strong class="text-danger">RÚT</strong> tối đa trong ngày</td>
                        @foreach($fees as $fee)
                            <td>{{ ($fee->total_daily_withdraw[$group]) ? number_format($fee->total_daily_withdraw[$group])." ".$fee->currency_code : 'Không giới hạn' }}</td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            @endif

        </div>
        <div class="clearfix"></div>
        <br>
        <div class="col-md-12 table-responsive">
            <h4><span class="text-uppercase">Lịch sử đơn hàng rút tiền</span></h4>

            <table class="table table-bordered table-striped dataTable">
                <thead>
                <tr>

                    <th>Mã GD</th>
                    <th>Rút từ ví</th>
                    <th>Số tiền</th>
                    <th>Tài khoản nhận</th>
                    <th>Ngày tạo</th>
                    <th>Ghi chú</th>
                    <th>Trạng thái</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $withdraws as $withdraw )
                    <tr>

                        <td>{{$withdraw->order_code}}</td>
                        <td>{{$withdraw->payer_wallet}}</td>
                        <td>-{{number_format($withdraw->net_amount)}} {{$withdraw->currency_code}}</td>

                        <td>
                            {!! $withdraw->payer_info !!}
                        </td>

                        <td>{{date('d-m-Y H:i', strtotime($withdraw->created_at))}}</td>
                        <td>{{$withdraw->description}}</td>
                        <td>

                            @if($withdraw->status == 'completed')
                                <span class="label label-success">HOÀN THÀNH</span>
                            @elseif($withdraw->status == 'pending')
                                <span class="label label-warning">ĐỢI CHUYỂN</span>
                            @elseif($withdraw->status == 'none')
                                <span class="label label-default">NHÁP</span>
                            @elseif($withdraw->status == 'canceled')
                                <span class="label label-danger">ĐÃ HỦY</span>
                            @else
                                <span class="label label-default">CHƯA RÕ</span>
                            @endif

                        </td>
                    </tr>
                @endforeach

                </tbody>

            </table>
            {{$withdraws->links()}}

        </div>



    </section>


@endsection



@section('js-footer')

@endsection

