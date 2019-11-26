@extends('master')

@section('css')
@endsection

@section('js')

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
                    <!-- /.card-header -->
                    <div class="card-header" style="border-bottom: 0">
                        <h3 class="card-title">Danh mục sản phẩm</h3>
                        <div class="float-right" style="margin-right: 150px">
                        </div>
                        <div class="float-right" style="margin-right: 150px">
                            <a href="{{ url($backendUrl.'/tiki/product/create') }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm danh mục</button></a>
                        </div>
                        <div class="card-tools ">
                            <div class="input-group input-group-sm dataTables_filter" style="width: 150px;">
                                <form action="" name="formSearch" method="GET" >
                                    <input type="text" name="keyword" class="form-control float-right" placeholder="Search" style="padding-right: 42px;">
                                    <div class="input-group-append" style="margin-left: 110px">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <form action="" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-body" style="padding-top: 50px;">
                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped dataTable" >
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Mã sản  phẩm</th>
                                        <th>Danh mục</th>
                                        <th>Giá nhập</th>
                                        <th>Giá bán</th>
                                        <th>Giá khuyến mãi</th>
                                        <th>Trang thái</th>
                                        <th>Nổi bật</th>
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
                                                <td>1</td>
                                                <td >{{$data->name}}</td>
                                                <td >@if($item->cats==$cate->id){{$cate->name}}@endif</td>
                                                <td>{{$item->inputprice}}</td>
                                                <td>{{$item->listedprice}}</td>
                                                <td>{{$item->special_price}}</td>
                                                <td>
                                                    <div data-table="product" data-id="{{ $item->id }}" data-col="status" class="Switch Round @if($item->status == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                                                        <div class="Toggle" ></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div data-table="product" data-id="{{ $item->id }}" data-col="hotdeal" class="Switch Round @if($item->hotdeal == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                                                        <div class="Toggle" ></div>
                                                    </div>
                                                </td>
                                                <td style="width: 10%;text-align: center; font-size: 2rem;">
                                                    <div class="action-buttons">
                                                        <a href="{{ url($backendUrl.'/tiki/product/edit/'.$item->id) }}"> <span class="btn btn-sm btn-info"><i title="Sửa" class="ace-icon fa fa-pencil bigger-130"></i></span></a>
                                                        <a href="#" name="{{ $data->name }}" link="{{ url($backendUrl.'/tiki/product/delete/'.$item->id) }}" class="deleteClick red id-btn-dialog2" data-toggle="modal" data-target="#deleteModal" > <span class="btn btn-sm btn-danger"><i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></span></a>
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
