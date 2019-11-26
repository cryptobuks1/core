@extends('frontend.'.$current_theme.'.app')
@section('breadcrumbs', Breadcrumbs::render('wallet'))

@section('content')
    <h4><span class="text-uppercase">Các ví điện tử</span></h4>
    <section class="main">

        <div class="blockContent">
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th>Loại ví</th>
                    <th>Địa chỉ ví</th>
                    <th>Số dư khả dụng</th>
                    <th>Số dư tạm giữ</th>
                    <th>Trạng thái</th>
                </tr>
                </thead>
                <tbody>
                @foreach($wallets as $wallet)
                    <tr>
                        <td>{{$wallet['currency_code']}}</td>
                        <td><b>{{$wallet['number']}}</b></td>
                        <td>
                            <span class="text-success"><b>{{$wallet['balance']}} {{strtolower($wallet['currency_code'])}}</b></span>
                        </td>
                        <td>
                            <span class="text-danger"><i>{{$wallet['pending_balance']}} {{strtolower($wallet['currency_code'])}}</i></span>
                        </td>
                        <td>@if($wallet['status'] == 1)<span class="label label-success">Hoạt động</span> @else <span
                                    class="label label-danger">Bị khóa</span> @endif
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>

        </div>
        <br><br>
        <h4><span class="text-uppercase">Lịch sử thay đổi số dư</span></h4>

        <div class="blockContent">
            <div class="row table-responsive">
                <div class=" col-md-12">

                                    <table id="example1" class="table table-bordered table-striped dataTable">
                                        <thead>
                                        <tr>
                                            <th>Mã GD</th>
                                            <th>Ví</th>
                                            <th>Trước GD</th>
                                            <th>Số tiền</th>
                                            <th>Sau GD</th>
                                            <th>Tiền tệ</th>
                                            <th>Ngày tạo</th>
                                            <th>Ghi chú</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($trans) > 0)
                                            @foreach( $trans as $tran )
                                                <tr>
                                                    <td>{{$tran->order_code}}</td>
                                                    <td>{{$tran->wallet_number}}</td>
                                                    <td>{{number_format($tran->before_balance)}} {{$tran->currency_code}}</td>
                                                    <td>
                                                        <span class="text-success"><b>{{$tran->operation}}@if($tran->operation =="-"){{number_format($tran->pay_amount)}}@else{{number_format($tran->net_amount)}} @endif {{$tran->currency_code}}</b></span>
                                                    </td>
                                                    <td>{{number_format($tran->after_balance)}} {{$tran->currency_code}}</td>
                                                    <td>{{$tran->currency_code}}</td>
                                                    <td>{{date('d-m-Y H:i', strtotime($tran->created_at))}}</td>
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
    </section>
@endsection
