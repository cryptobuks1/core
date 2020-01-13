@extends('frontend.'.$current_theme.'.app')
@section('title')
@section('customstyle')

@section('customstyle')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100);
        body {
            font-family: "Roboto", helvetica, arial, sans-serif;
            text-rendering: optimizeLegibility;
        }
        div.table-title {
            display: block;
            margin: auto;
            max-width: 600px;
            padding:5px;
            width: 100%;
        }
        .table-title h3 {
            color: #fafafa;
            font-size: 30px;
            font-weight: 400;
            font-style:normal;
            font-family: "Roboto", helvetica, arial, sans-serif;
            text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
            text-transform:uppercase;
        }
        /*** Table Styles **/
        .table-fill {
            background: white;
            border-radius:3px;
            border-collapse: collapse;
            margin: auto;
            padding:5px;
            width: 100%;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            animation: float 5s infinite;
        }
        th {
            color:white;;
            background:#0a3461;
            border-bottom:4px solid #9ea7af;
            border-right: 1px solid #343a45;
            font-size:15px;
            font-weight: 100;
            padding:24px;
            text-align:left;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            vertical-align:middle;
        }
        th:first-child {
            border-top-left-radius:3px;
        }
        th:last-child {
            border-top-right-radius:3px;
            border-right:none;
        }
        tr {
            border-top: 1px solid #C1C3D1;
            border-bottom-: 1px solid #C1C3D1;
            color:#666B85;
            font-weight:normal;
            text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
        }
        tr:hover td {
            background:#4E5066;
            color:#FFFFFF;
            border-top: 1px solid #22262e;
        }
        tr:first-child {
            border-top:none;
        }
        tr:last-child {
            border-bottom:none;
        }
        tr:nth-child(odd) td {
            background:#EBEBEB;
        }
        tr:nth-child(odd):hover td {
            background:#4E5066;
        }
        tr:last-child td:first-child {
            border-bottom-left-radius:3px;
        }
        tr:last-child td:last-child {
            border-bottom-right-radius:3px;
        }
        td {
            background:#FFFFFF;
            text-align:left;
            vertical-align:middle;
            text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
            border-right: 1px solid #C1C3D1;
        }
        td:last-child {
            border-right: 0px;
        }
        th.text-left {
            text-align: center;
        }
        td.text-left {
            text-align: left;
        }
        td.text-center {
            text-align: center;
        }
        td.text-right {
            text-align: right;
        }
    </style>

@endsection

@section('content')
    @include('frontend.default.realestates.menu')
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card">
                    <div class="card-header" style="border-bottom: 0">
                        <h3 class="card-title" style="text-align: center; text-transform: uppercase; color: #0b6998">Danh sách tin rao</h3>
                        <div class="" >
                            <a href="{{ route('tin.create') }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Đăng tin rao</button></a>
                            <a href="{{route('tin.list.order')}}" class="btn btn-warning">List Order</a>
                            @if($user->broker==0)
                            <a href="{{route('broker.create')}}" class="btn btn-primary">Thêm môi giới</a>
                            @else
                            <a href="{{asset('realestates/broker/edit/'.$broker->id)}}" class="btn btn-primary">Thông tin môi giới</a>
                            @endif
                        </div>

                        <div class="card-tools ">
                            <div class="input-group input-group-sm dataTables_filter" style="width: 150px;">
                            </div>
                        </div>
                    </div>
                    <div class="card-tools ">
                        <div class="" style="width: 250px; float: right">
                            <form action="" name="formSearch" method="GET" >
                                <div style="display: flex">
                                    <input type="text" name="keyword" class="form-control " placeholder="Search" style="margin-right: 10px; transform: translateY(3px)" value="@if(app("request")->input("keyword")){{ trim(app("request")->input("keyword"))}}@endif">
                                    <button type="submit" class="btn btn-primary" ><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <form action="" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-body" style="padding-top: 50px;">
                            <div class="col-sm-12 ">
                                <table id="example1" class=" table-fill table table-bordered table-striped dataTable" >
                                    <thead>
                                    <tr >
                                        <th class="text-left">ID</th>
                                        <th class="text-left">Tiêu đề</th>
                                        <th class="text-left">Diện tích</th>
                                        <th class="text-left">Giá</th>
                                        <th class="text-left">Ngày hết hạn</th>
                                        <th class="text-left">Trạng thái</th>
                                        <th class="text-left">Nổi bật</th>
                                        <th class="text-left">Phê duyệt</th>
                                        <th class="text-left">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-hover">
                                    @if(!count($data))
                                        <tr >
                                            <td colspan="12" class="text-center alert alert-info">Chưa có dữ liệu
                                            </td>
                                        </tr>
                                    @else
                                    @foreach($data as $item)
                                        <tr>
                                            <td class="text-left">{{$item->id}}</td>
                                            <td class="text-left">{{$item->title}}</td>
                                            <td class="text-left">{{$item->acreage}}</td>
                                            <td class="text-left">{{number_format($item->price,0)}}</td>
                                            <td class="text-left" style="width: 10%">{{$item->end_date}}</td>
                                            <td class="text-left" id="status"  data-key="{{$item->status}}"style="width: 10%; font-size: 15px; font-weight: 700; text-align: center" >

                                                @if($item->status===1)
                                                    <span style="color: green"> Bật</span>
                                                @elseif($item->status===0)  <span style="color: gray; ">Tắt</span>
                                                @else <span>Đã hết hạn</span>@endif
                                            </td>
                                            <td id="featured" class="text-left" data-key="{{$item->featured}}"style="width: 10%; font-size: 15px; font-weight: 700; text-align: center" >
                                                @if($item->featured===1)
                                                    <span style="color: red">Tin Vip</span>
                                                @else($item->featured===0)  <span style="color: gray; ">Tin Thường</span>
                                                 @endif</td>
                                            <td id="approved"  class="text-left" data-key="{{$item->approved}}"style="width: 10%; font-size: 15px; font-weight: 700; text-align: center" >
                                                @if($item->approved===1)
                                                    <span style="color: green">Đã Duyệt</span>
                                                @elseif($item->approved===0)  <span style="color: gray; ">Chưa Duyệt</span>
                                                @endif
                                            </td>
                                            <td style="width: 15%;text-align: center; font-size: 2rem;" class="text-left">
                                                <div class="action-buttons">
                                                    <a href="{{ asset('realestates/edit/'.$item->id)}}"><span class="btn btn-warning" > <i title="Sửa" class="ace-icon fa fa-pencil bigger-130" ></i></span></a>
                                                    <a href="{{ asset('realestates/vip/'.$item->id.'/'.$item->slug)}}"><span class="btn btn-primary" > <i title="Mua Vip" class="fa fa-vimeo bigger-130" ></i></span></a>
                                                    <a href="#" name="{{$item->title}}" link="{{ asset('/realestates/delete/'.$item->id)}}" class="deleteClick red id-btn-dialog2"data-toggle="modal" data-target="#deleteModal" > <span class="btn btn-danger"><i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></span></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                {{$data->links()}}
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

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="deleteForm" action="" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Danh Mục</h5>
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


@section('js-footer')
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();
            });
        $(document).ready(function(){
            $(".deleteClick").click(function(){
                var link = $(this).attr('link');
                var name = $(this).attr('name');
                console.log(link);
                $("#deleteForm").attr('action',link);
                $("#deleteMes").html("Delete : "+name+" ?");
            });
        });
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
