@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    <style>
        .tim{
            color: #ff1aad;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('adminlte/plugins/fastclick/fastclick.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#fromdate').datepicker({
                dateFormat:"dd-mm-yy",
            });
            $('#todate').datepicker({
                dateFormat:"dd-mm-yy",
            });
        });
        $(document).ready(function() {
            $("#type").on('change', (function(e){
                var form_code = $(this).val();
                $.ajax({
                    type:'POST',
                    url:'{{ route('ajax.fund.type') }}',
                    data:{code:form_code},
                    success:function(data){
                        $('#reason').html(data);
                    }
                });
            }));
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".deleteClick").click(function(){
                var link = $(this).attr('link');
                var name = $(this).attr('name');
                $("#deleteForm").attr('action',link);
                $("#deleteMes").html("Delete : "+name+" ?");
            });
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
                        <h3 class="card-title">Danh sách hóa đơn</h3>
                        <div class="float-right" style="margin-right: 150px">
                            <a href="{{ url($backendUrl.'/fund/trans') }}"><button class="btn btn-success"><i class="fa fa-money"></i> Tạo phiếu</button></a>
                        </div>
                        <div class="card-tools " style="">
                            <div class="input-group input-group-sm dataTables_filter" style="width: 150px">
                                <form action="" name="formSearch" method="GET" >
                                    <input type="text" name="keyword" class="form-control float-right" placeholder="Tìm theo tên" style="padding-right: 42px;" value="@if(app("request")->input("keyword")){{ trim(app("request")->input("keyword"))}}@endif">
                                    <div class="input-group-append" style="margin-left: 110px">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-tools " style="float: left;position: relative;right: 0px;left: 0px; padding-top: 20px">
                            <div class="input-group input-group-sm dataTables_filter" style="">
                                <form action="" name="formSearch" method="GET" >
                                    <div class="input-group">
                                        <select name="type" class="form-control" style="" id="type">
                                            <option value="" @if(app("request")->input("type")== "") selected="selected" @endif>--Lọc theo loại phiếu--</option>
                                            <option value="Phiếu thu" @if(app("request")->input("type")== 'Phiếu thu') selected="selected" @endif>Phiếu thu</option>
                                            <option value="Phiếu chi" @if(app("request")->input("type")== 'Phiếu chi') selected="selected" @endif>Phiếu chi</option>
                                        </select>
                                        <select name="reason" id="reason" class="form-control">
                                            <option value="" @if(app("request")->input("reason")== "") selected="selected" @endif>--Lọc theo lý do--</option>
                                            @if(app("request")->input("type"))
                                                @foreach($reasons as $item)
                                                    <option value="{{$item->name}}" @if(app("request")->input("type")==$item->type && app("request")->input("reason")==$item->name) selected="selected" @endif>{{$item->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <select name="funds" id="funds" class="form-control">
                                            <option value="" @if(app("request")->input("funds")== "") selected="selected" @endif>--Lọc tài khoản--</option>
                                            @foreach($funds as $item)
                                                <option value="{{$item->id}}" @if(app("request")->input("funds")==$item->id && (app("request")->input("reason")==$item->sender_fund_id | app("request")->input("reason")==$item->receiver_fund_id)) selected="selected" @endif>{{$item->name}}</option>
                                                @endforeach
                                        </select>
                                        <input type="text" class="form-control" placeholder="Chọn gày bắt đầu" id="fromdate" name="fromdate" value="@if(app("request")->input("fromdate")){{ trim(app("request")->input("fromdate"))}}@endif">
                                        <input type="text" class="form-control" placeholder="Chọn ngày kết thúc" id="todate" name="todate" value="@if(app("request")->input("todate")){{ trim(app("request")->input("todate"))}}@endif">
                                        <div class="input-group-append">
                                            <button type="submit" name="submit" value="filter" class="btn btn-warning"><i class="fa fa-search"></i> Lọc</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <form action="" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-body" style="padding-top: 0;">
                            <div class="row table-responsive"><div class="col-sm-12">
                                    <table id="example1" class="table table-bordered table-striped dataTable">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Loại phiếu</th>
                                            <th>Người chuyển</th>
                                            <th>Người nhận</th>
                                            <th>Tổng tiền</th>
                                            <th>Lý do</th>
                                            <th>Ghi chú</th>
                                            <th>Số dư trước</th>
                                            <th>Số dư sau</th>
                                            <th>Ngày tạo</th>
                                            <th>Phê duyệt</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        @if(count($fund_tras)>0)
                                        <tbody>
                                            @foreach( $fund_tras as $fund )
                                                <tr>
                                                    <td>{{$fund->id}}</td>
                                                    <td>@if($fund->type==='Phiếu thu')
                                                            <label class="badge badge-primary">Phiếu Thu</label>
                                                        @else
                                                            <label class="badge badge-danger">Phiếu Chi</label>
                                                        @endif</td>
                                                    <td>
                                                        @if($fund->type=='Phiếu thu')
                                                            -Tên: {{$fund->name}} <br>
                                                            -SDT: {{$fund->phone}} <br>
                                                            -Địa chỉ: {{$fund->address}}
                                                        @else
                                                                @foreach($funds as $item)
                                                                    @if($item->id==$fund->sender_fund_id)
                                                                        -{{$item->name}} <br>
                                                                        -STK: {{$item->acc_number}} <br>
                                                                    @endif
                                                                @endforeach

                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($fund->type=='Phiếu chi')
                                                            -Tên: {{$fund->name}} <br>
                                                            -SDT: {{$fund->phone}} <br>
                                                            -Địa chỉ: {{$fund->address}}
                                                        @else
                                                                @foreach($funds as $item)
                                                                    @if($item->id==$fund->receiver_fund_id)
                                                                        -{{$item->name}} <br>
                                                                        -STK: {{$item->acc_number}} <br>
                                                                    @endif
                                                                @endforeach
                                                        @endif
                                                    </td>
                                                    <td><label class="badge" style="font-size: 14px">
                                                            {{number_format($fund->total,0).' '.$fund->currency_code}} <br>
                                                        </label></td>
                                                    <td>{{$fund->reason}}</td>
                                                    <td><label for="">{{number_format($fund->before_balance).''.$fund->currency_code}}  </label></td>
                                                    <td><label for="">{{number_format($fund->after_balance).''.$fund->currency_code}}  </label></td>
                                                    <td>{{date_format($fund->created_at,'d/m/Y')}}</td>
                                                    <td>@if($fund->status=='complete')
                                                            <label class="badge badge-success">Hoàn thành</label>
                                                        @else
                                                            <label class="badge badge-warning">Chưa hoàn thành</label>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($fund->approved==1)
                                                            <label class="badge badge-success">Đã duyệt</label>
                                                        @else
                                                            <label class="badge badge-warning">Chưa duyệt</label>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <a href="{{ url($backendUrl.'/fund/order/edit/'.$fund->id) }}"class="btn btn-primary"> Xem </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @else
                                            <span>Không có dữ liệu</span>
                                        @endif
                                    </table>
                                </div></div>
                            {{$fund_tras->links()}}
                        </div></form>

                    <!-- Delete form -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form id="deleteForm" action="" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div id="deleteMes" class="modal-body">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
