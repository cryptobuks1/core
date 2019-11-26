@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.css') }}">
@endsection

@section('js')
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('adminlte/plugins/fastclick/fastclick.js') }}"></script>
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
                                            <option value="payer" @if(app("request")->input("type")=="payer") selected="selected" @endif>Theo ví gửi</option>
                                            <option value="payee" @if(app("request")->input("type")=="payee") selected="selected" @endif>Theo ví nhận</option>
                                            <option value="ip" @if(app("request")->input("type")=="ip") selected="selected" @endif>Theo IP</option>
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
                                        <th>Người gửi</th>
                                        <th>Người nhận</th>
                                        <th>Số tiền</th>
                                        <th>Phí</th>
                                        <th>Thời gian</th>
                                        <th>Nội dung</th>
                                        <th>IP</th>

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
                                            <td>{!! App\User::getUserInfo($tran->payer_id) !!}<br><b>Ví: {{ $tran->payer_wallet}}</b></td>
                                            <td>{!! App\User::getUserInfo($tran->payee_id) !!}<br><b>Ví: {{ $tran->payee_wallet}}</b></td>
                                            <td>{{ number_format($tran->net_amount).' '.$tran->currency_code }}</td>
                                            <td>{{ number_format($tran->fees).' '.$tran->currency_code }}</td>
                                            <td>{{$tran->created_at}}</td>
                                            <td>
                                                {{ $tran->description }}
                                            </td>
                                            <td>{{$tran->ipaddress}}</td>


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


