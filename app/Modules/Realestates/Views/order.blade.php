@extends('master')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".deleteClick").click(function(){
                var link = $(this).attr('link');
                var name = $(this).attr('name');
                $("#deleteForm").attr('action',link);
                $("#deleteMes").html("Delete : "+name+" ?");
            });
        });
        $(document).ready(function() {
            $('#fromdate').datepicker({
                dateFormat:"dd-mm-yy",
            });
            $('#todate').datepicker({
                dateFormat:"dd-mm-yy",
            });
        });
    </script>
@endsection

@section('content')
    <!-- Main content -->
    <style>
        table tr th{
            text-align: center;
        }
    </style>
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card">
                    <h3>Quản lý hóa đơn thanh toán</h3>
                    <!-- /.card-header -->
                    <div class="card-header" style="border-bottom: 0">
                        <div class="card-tools " style="float: left;position: relative;right: 0px;left: 0px;">
                            <div class="input-group input-group-sm dataTables_filter" style="">
                                <form action="" name="formSearch" method="GET" >
                                    <div class="input-group">
                                        <select name="vip" class="form-control" style="">
                                            <option value="" @if(app("request")->input("vip")== "") selected="selected" @endif>--Lọc theo gói  vip--</option>
                                            @foreach($vip as $item)
                                                <option value="{{$item->level}}" @if(app("request")->input("vip")== $item->level) selected="selected" @endif>{{$item->name}}</option>
                                            @endforeach
                                        </select>

                                        <input type="text" class="form-control" placeholder="Chọn gày bắt đầu" id="fromdate" name="fromdate" value="@if(app("request")->input("fromdate")){{ trim(app("request")->input("fromdate"))}}@endif">
                                        <input type="text" class="form-control" placeholder="Chọn ngày kết thúc" id="todate" name="todate" value="@if(app("request")->input("todate")){{ trim(app("request")->input("todate"))}}@endif">

                                        <input type="text" class="form-control" placeholder="Search" name="title" value="@if(app("request")->input("title")){{ trim(app("request")->input("title"))}}@endif">

                                        <div class="input-group-append">
                                            <button type="submit" name="submit" value="filter" class="btn btn-warning"><i class="fa fa-search"></i> Lọc</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <form action="" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-body" style="padding-top: 50px;">
                            <div class="col-sm-12">
                                <table id="example1" class=" table-fill table table-bordered table-striped dataTable" >
                                    <thead>
                                    <tr>
                                        <th class="text-left">ID</th>
                                        <th class="text-left">Tiêu đề tin rao</th>
                                        <th class="text-left">Loại tin</th>
                                        <th class="text-left">Giá</th>
                                        <th class="text-left">Ngày đăng tin</th>
                                        <th class="text-left">Ngày hết hạn</th>
                                        <th class="text-left">Ngày thanh toán</th>
                                        <th class="text-left">Trạng thái</th>
                                        <th class="text-left">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-hover">
                                    @if(!count($orders))
                                        <tr >
                                            <td colspan="12" class="text-center alert alert-info">Chưa có dữ liệu
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($orders as $order)
                                            <tr>
                                                <td class="text-left">{{$order->id}}</td>
                                                <td class="text-left" style="width: 30%">{{$order->realestates_title}}</td>
                                                <td class="text-left" >{{$order->vip_name}}</td>
                                                <td class="text-left" >{{number_format($order->price,0)}}VNĐ</td>
                                                <td class="text-left">{{$order->vip_startdate}}</td>
                                                <td class="text-left">{{$order->vip_enddate}}</td>
                                                <td class="text-left">{{$order->updated_at}}</td>
                                                <td class="text-left" id="status"  data-key="{{$order->status}}"style="width: 15%; font-size: 15px; font-weight: 700; text-align: center" >
                                                    @if($order->status==='completed')
                                                        <span style="color: green">Hoàn thành</span>
                                                    @else  <span style="color: gray; ">Chưa hoàn thành</span> @endif
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="#" name="{{$order->title}}" link="{{ asset('/realestates/order/delete/'.$order->id)}}" class="deleteClick red id-btn-dialog2"data-toggle="modal" data-target="#deleteModal" > <span class="btn btn-danger"><i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></span></a>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{$orders->links()}}
                    </form>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- Main content -->
    <!-- /.content -->

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
@endsection
