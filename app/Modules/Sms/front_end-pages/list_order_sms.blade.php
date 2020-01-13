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
                                        <th class="text-left">Order Code</th>
                                        <th class="text-left">Người gửi</th>
                                        <th class="text-left">Số tiền</th>
                                        <th class="text-left">Nội dung</th>
                                        <th class="text-left">Trạng thái</th>
                                        <th class="text-left">Thanh toán</th>
                                        <th class="text-left">Thời gian</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-hover">
                                    @if(!count($datas) < 0)
                                        <tr >
                                            <td colspan="12" class="text-center alert alert-info">Chưa có dữ liệu
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($datas as $data)
                                            <tr>
                                                <td>{{$data->id}}</td>
                                                <td>{{$data->order_code}}</td>
                                                <td>@foreach($users as $user)
                                                        @if($user->id == $data->payer_id)
                                                            ID:    {{$user->id}}<br>
                                                            Name:  {{$user->name}} <br>
                                                            Email: {{$user->email}} <br>
                                                            Phone: {{$user->phone}}
                                                        @endif
                                                    @endforeach</td>
                                                <td>{{$data->net_amount.''.$data->currency_code}}</td>
                                                <td>{{$data->description}}</td>
                                                <td>@if($data->status == 'completed')<label style="background-color: #28a745; color: #fff " class="badge badge-success">Thành công</label> @else<label style="background-color: #ffc107;color: #fff" class="badge badge-warning">Chưa thành công</label> @endif</td>
                                                <td>@if($data->payment == 'paid')<label style="background-color: #28a745; color: #fff " class="badge badge-success">Đã thanh toán</label> @else<label style="background-color: #ffc107;color: #fff" class="badge badge-warning">Chưa thanh toán</label> @endif</td>
                                                <td>{{\Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i:s')}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                {{$datas->links()}}
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
