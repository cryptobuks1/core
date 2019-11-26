@extends('master')

@section('css')

@endsection

@section('js')

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

@endsection

@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card">

                    <div class="card-header" style="border-bottom: 0">

                        <div class="float-right" style="">

                                <form action="" name="formSearch" method="GET" >
                                    <div class="input-group">
                                        <select name="type" class="form-control" style="">
                                            <option value="order_code" @if(app("request")->input("type")=="order_code") selected="selected" @endif>Mã giao dịch</option>
                                            <option value="wallet" @if(app("request")->input("type")=="wallet") selected="selected" @endif>Theo số ví</option>
                                            <option value="email" @if(app("request")->input("type")=="email") selected="selected" @endif>Theo email</option>
                                            <option value="phone" @if(app("request")->input("type")=="phone") selected="selected" @endif>Theo số điện thoại</option>
                                            <option value="description" @if(app("request")->input("type")=="description") selected="selected" @endif>Nội dung giao dịch</option>
                                        </select>
                                        <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm" value="{{ app("request")->input("keyword") }}" />
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="padding-top: 0;">
                        <div class="row table-responsive"><div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped ">
                                    <thead>
                                    <tr>

                                        <th>TT</th>
                                        <th>Mã đơn</th>
                                        <th>Khách hàng</th>
                                        <th>Số dư trước</th>
                                        <th>Số tiền</th>
                                        <th>Số dư sau</th>
                                        <th>Thời gian</th>
                                        <th>Nội dung</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $trans as $tran )
                                        <tr class="irow" data-id="{{ $tran->id }}">
                                            <td>{{ $tran->id }}</td>
                                            <td>{{ $tran->order_code }}
                                            <br>
                                                @if($tran->user_id !==1 && $tran->operation =='+')
                                                <a href="{{url($backendUrl.'/transaction/chargeback/'.$tran->id) }}"><button data-toggle="tooltip" title="Lưu ý: Nhấn là hệ thống sẽ thực hiện rút tiền ngay! Hãy kiểm tra kỹ trước khi thực hiện." class="btn btn-danger">Truy thu lại tiền</button></a>
                                                @endif

                                            </td>
                                            <td>{!! App\User::getUserInfo($tran->user_id) !!}<br><b>Ví: {{ $tran->wallet_number}}</b></td>
                                            <td>{{ number_format($tran->before_balance).' '.$tran->currency_code }}</td>
                                            <td>{{ $tran->operation }}@if($tran->operation =="-"){{number_format($tran->pay_amount)}}@else{{number_format($tran->net_amount)}} @endif {{ $tran->currency_code }}</td>
                                            <td>{{ number_format($tran->after_balance).' '.$tran->currency_code }}</td>

                                            <td>{{ $tran->created_at }}</td>
                                            <td>
                                                {{ $tran->description }}
                                            </td>


                                        </tr>
                                    @endforeach

                                    </tbody>


                                </table>
                            </div></div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="float-right" id="dynamic-table_paginate">
                            {{ $trans->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete form -->
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $(".deleteClick").click(function(){
                                var link = $(this).attr('link');
                                var name = $(this).attr('name');
                                $("#deleteForm").attr('action',link);
                                $("#deleteMes").html("Xóa : "+name+" ?");
                            });
                        });
                    </script>
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form id="deleteForm" action="" method="GET">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Xóa mã thẻ</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div id="deleteMes" class="modal-body">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary">Xóa mã thẻ</button>
                                    </div>
                                    <input type="hidden" name="_method" value="delete" />
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                    </div>
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


