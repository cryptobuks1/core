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
        $(document).ready(function() {
            $("#form").on('change', (function(e){
                var form_code = $(this).val();
                $.ajax({
                    type:'POST',
                    url:'{{ route('ajax.form2') }}',
                    data:{code:form_code},
                    success:function(data){
                        $('#type').html(data);
                    }
                });
            }));
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
                    <h3>Quản lý tin rao</h3>
                    <div class="card-header" style="border-bottom: 0">
                        <div class="card-tools " style="float: left;position: relative;right: 0px;left: 0px;">
                            <div class="input-group input-group-sm dataTables_filter" style="">
                                <form action="" name="formSearch" method="GET" >
                                    <div class="input-group">
                                        <select name="form" class="form-control" style="" id="form">
                                            <option value="" @if(app("request")->input("form")== "") selected="selected" @endif>--Lọc theo nhà đất--</option>
                                            <option value="1" @if(app("request")->input("form")== 1) selected="selected" @endif>Nhà đất bán</option>
                                            <option value="2" @if(app("request")->input("form")== 2) selected="selected" @endif>Nhà đất thuê</option>
                                        </select>
                                        <select name="type" id="type" class="form-control">
                                            <option value="" @if(app("request")->input("type")== "") selected="selected" @endif>--Lọc theo loại tin đăng--</option>
                                            @if(app("request")->input("form"))
                                                @foreach($type as $item)
                                                    <option value="{{$item->name}}" @if(app("request")->input("form")==$item->form_id && app("request")->input("type")==$item->name) selected="selected" @endif>{{$item->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                            <input type="text" class="form-control" placeholder="Nhập từ khóa cần tìm kiếm" name="title" value="@if(app("request")->input("title")){{ trim(app("request")->input("title"))}}@endif">

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
                        <div class="card-body" style="padding-top: 50px;">
                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped dataTable" >
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User ID</th>
                                        <th>Tiêu đề</th>
                                        <th>Địa chỉ</th>
                                        <th>Diện tích</th>
                                        <th>Giá</th>
                                        <th>Số điện thoại</th>
                                        <th>Trạng thái</th>
                                        <th>Nổi bật</th>
                                        <th>Phê duyệt</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!count($data))
                                        <tr>
                                            <td colspan="12" class="text-center alert alert-info">Chưa có dữ liệu
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($data as $item)
                                            <tr>
                                                <td>{{$item->id}}</td>
                                                <th>{{$item->user_id}}</th>
                                                <td>{{$item->title}}</td>
                                                <td >{{$item->address}}</td>
                                                <td style="width: 10%">{{$item->acreage}}</td>
                                                <td>{{number_format($item->price,0)}}</td>
                                                <td>{{$item->phone_contact}}</td>
                                                <td>
                                                    @if($item->status==3)
                                                        <span>Đã hết hạn</span>
                                                    @else
                                                        <div data-table="realestates" data-id="{{ $item->id }}" data-col="status" class="Switch Round @if($item->status == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                                                            <div class="Toggle" ></div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div data-table="realestates" data-id="{{ $item->id }}" data-col="featured" class="Switch Round @if($item->featured == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                                                        <div class="Toggle" ></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div data-table="realestates" data-id="{{ $item->id }}" data-col="approved" class="Switch Round @if($item->approved == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                                                        <div class="Toggle" ></div>
                                                    </div>
                                                </td>
                                                <td style="width: 10%;text-align: center">
                                                    <div class="action-buttons">
                                                        <a href="{{ url($backendUrl.'/realestates/edit/'.$item->id) }}"> <span class="btn btn-sm btn-info"><i title="Sửa" class="ace-icon fa fa-pencil bigger-130"></i></span></a>
                                                        <a href="#" name="{{ $item->name }}" link="{{ url($backendUrl.'/realestates/delete/'.$item->id) }}" class="deleteClick red id-btn-dialog2" data-toggle="modal" data-target="#deleteModal" > <span class="btn btn-sm btn-danger"><i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></span></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
