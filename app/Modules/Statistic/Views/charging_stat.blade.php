@extends('master')

@section('css')
@endsection

@section('js')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
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

@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card table-responsive">

                    <div class="card-header" style="border-bottom: 0">
                        <div class="card-tools " style="float: left;position: relative;right: 0px;left: 0px;">
                            <div class="input-group input-group-sm dataTables_filter" style="">
                                <form action="" name="formSearch" method="GET" >
                                    <div class="input-group">
                                        <select name="telco" class="form-control" style="">
                                            <option value="all" @if(app("request")->input("telco")=="all") selected="selected" @endif>Loại thẻ</option>
                                            @if(count($telcos))
                                            @foreach($telcos as $telco)
                                            <option value="{{$telco->key}}" @if(app("request")->input("telco")==$telco->key) selected="selected" @endif>{{$telco->key}}</option>
                                                @endforeach
                                                @endif
                                        </select>

                                        <select name="value" class="form-control" style="">

                                            <option value="" @if(app("request")->input("value")=="") selected="selected" @endif>Mệnh giá</option>
                                            <option value="10000" @if(app("request")->input("value")=="10000") selected="selected" @endif>10.000đ</option>
                                            <option value="20000" @if(app("request")->input("value")=="20000") selected="selected" @endif>20.000đ</option>
                                            <option value="30000" @if(app("request")->input("value")=="30000") selected="selected" @endif>30.000đ</option>
                                            <option value="50000" @if(app("request")->input("value")=="50000") selected="selected" @endif>50.000đ</option>
                                            <option value="100000" @if(app("request")->input("value")=="100000") selected="selected" @endif>100.000đ</option>
                                            <option value="200000" @if(app("request")->input("value")=="200000") selected="selected" @endif>200.000đ</option>
                                            <option value="300000" @if(app("request")->input("value")=="300000") selected="selected" @endif>300.000đ</option>
                                            <option value="500000" @if(app("request")->input("value")=="500000") selected="selected" @endif>500.000đ</option>
                                            <option value="1000000" @if(app("request")->input("value")=="1000000") selected="selected" @endif>1.000.000đ</option>
                                            <option value="2000000" @if(app("request")->input("value")=="2000000") selected="selected" @endif>2.000.000đ</option>
                                            <option value="3000000" @if(app("request")->input("value")=="3000000") selected="selected" @endif>3.000.000đ</option>
                                            <option value="5000000" @if(app("request")->input("value")=="5000000") selected="selected" @endif>5.000.000đ</option>

                                        </select>

                                        <select name="status" class="form-control" style="">
                                            <option value="correct" @if(app("request")->input("status")== "correct") selected="selected" @endif>Thẻ đúng</option>
                                            <option value="wrong" @if(app("request")->input("status")== "wrong") selected="selected" @endif>Sai mệnh giá</option>
                                            <option value="invalid" @if(app("request")->input("status")== "invalid") selected="selected" @endif>Thẻ lỗi</option>
                                            <option value="waiting" @if(app("request")->input("status")== "waiting") selected="selected" @endif>Thẻ chờ</option>
                                        </select>

                                        <select name="provider" class="form-control" style="">
                                            <option value="" @if(app("request")->input("provider")== "") selected="selected" @endif>Nhà cung cấp</option>
                                            <option value="Me" @if(app("request")->input("provider")== "Me") selected="selected" @endif>Tự xử lý</option>
                                            @if(count($providers) > 0)
                                            @foreach($providers as $provider)
                                            <option value="{{$provider->provider}}" @if(app("request")->input("provider")== $provider->provider) selected="selected" @endif>{{$provider->provider}}</option>
                                                @endforeach
                                                @endif
                                        </select>

                                        <input class="form-control" value="@if(app("request")->input("fromdate")){{ trim(app("request")->input("fromdate"))}}@else{{ trim(date('d-m-Y', time()))}}@endif" name="fromdate" id="datepicker">
                                        <input class="form-control" value="@if(app("request")->input("todate")){{ trim(app("request")->input("todate"))}}@else{{ trim(date('d-m-Y', time()))}}@endif" name="todate" id="datepicker2">

                                        <input class="form-control" value="@if(app("request")->input("user_id")){{ trim(app("request")->input("user_id"))}}@endif" name="user_id" placeholder="Mã khách hàng">


                                        <div class="input-group-append">
                                            <button type="submit" name="submit" value="filter" class="btn btn-warning"><i class="fa fa-search"></i> Lọc</button>
                                            <button type="submit" name="submit" value="excel" class="btn btn-success"><i class="fa fa-download"></i> Excel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="padding-top: 0;">
                        <div class="row table-responsive"><div class="col-sm-12">
                                <table class="table table-bordered table-striped ">
                                    <thead>
                                    <tr>

                                        <th>TT</th>
                                        <th>Thông tin thẻ</th>
                                        <th>Mạng</th>
                                        <th>NCC</th>
                                        <th>Khách hàng</th>
                                        <th>Khai báo</th>
                                        <th>Mệnh giá</th>
                                        <th>Nhận</th>
                                        <th>Gửi lúc</th>
                                        <th>Duyệt lúc</th>
                                        <th>Hình thức</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach( $chargings as $charging )
                                        <tr class="irow" data-id="{{ $charging->id }}">

                                            <td>
                                                @if($charging->status == 1)
                                                    <label class="badge badge-success">Thành công</label>
                                                @elseif($charging->status == 2)
                                                    <label class="badge badge-success">Sai m.giá</label>
                                                @elseif($charging->status == 3)
                                                    <label class="badge badge-danger">Thẻ lỗi</label>
                                                @elseif($charging->status == 4)
                                                    <label class="badge badge-danger">Đã sử dụng</label>
                                                @else
                                                    <label class="badge badge-warning">Chờ</label>
                                                @endif
                                            </td>

                                            <td>
                                                M:{{ $charging->code }}<br>S:{{ $charging->serial }}


                                            </td>
                                            <td>{{ $charging->telco }} </td>
                                            <td>{{ $charging->provider }}</td>
                                            <td>{!! App\User::getUserInfo($charging->user) !!}</td>
                                            <td>{{ number_format($charging->declared_value).' '.$charging->currency_code}}</td>
                                            <td>{{ number_format($charging->real_value).' '.$charging->currency_code}}</td>
                                            <td>{{ number_format($charging->amount).' '.$charging->currency_code}}</td>
                                            <td>{{ $charging->created_at }}</td>
                                            <td><strong>{{ $charging->updated_at }}</strong></td>
                                            <td>{{ $charging->method}} <br> {{ $charging->request_id}}</td>


                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot>

                                    <tr>

                                        <th colspan="5" class="text-right">Tổng số:</th>
                                        <th>{{ number_format($total->sum('declared_value'))}} đ</th>
                                        <th>{{ number_format($total->sum('real_value'))}} đ</th>
                                        <th>{{ number_format($total->sum('amount')) }} đ</th>
                                        <th colspan="3"></th>

                                    </tr>
                                    </tfoot>

                                </table>

                            </div></div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="float-right" id="dynamic-table_paginate">
                                    {{$chargings->appends(request()->query())->links()}}
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Delete form -->


                    <!-- End Delete form-->


                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection


