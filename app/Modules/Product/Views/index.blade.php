@extends('master')
@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.css') }}">
@endsection
@section('js')
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card">
                    <div class="card-header" style="border-bottom: 0">
                        <h3 class="card-title">Product List</h3>
                        <div class="float-right" style="margin-right: 350px">
                            <a href="{{ url($backendUrl.'/product/create') }}">
                                <button class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm mới
                                </button>
                            </a>
                        </div>
                        <div class="card-tools ">
                            <div class="input-group dataTables_filter" style="width:350px">
                                <form action="" name="formSearch" method="GET">
                                    <div class="input-group">
                                        <select name="type" class="form-control" style="">
                                            <option value="">-- Search Type --</option>
                                            <option value="name"
                                                    @if(app("request")->input("type")=="name") selected="selected" @endif>
                                                By Name
                                            </option>
                                            <option value="description"
                                                    @if(app("request")->input("type")=="description") selected="selected" @endif>
                                                By Description
                                            </option>
                                            <option value="status"
                                                    @if(app("request")->input("type")=="status") selected="selected" @endif>
                                                By Status (0 is Inactive/1 is Active)
                                            </option>
                                        </select>
                                        <input type="text" name="keyword" class="form-control" placeholder="Search"
                                               value="{{ app("request")->input("keyword") }}"/>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <form action="{{ url($backendUrl.'/product') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-body" style="padding-top: 0;">
                            <div class="row">
                                <div class="col-sm-12 table-responsive">
                                    <table id="example1" class="table table-bordered table-striped dataTable">
                                        <thead>
                                        <tr>
                                            <th class="center sorting_disabled" rowspan="1" colspan="1" aria-label="">
                                                <label class="pos-rel">
                                                    <input type="checkbox" class="ace" id="checkall">
                                                    <span class="lbl"></span> </label>
                                            </th>
                                            <th>ID</th>
                                            <th>Hình ảnh</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Danh mục</th>
                                            <th>Giá niêm yết</th>
                                            <th>Tồn kho</th>
                                            <th>Còn hàng</th>
                                            <th>Loại</th>
                                            <th>Trạng thái</th>
                                            <th>Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(!count($product))
                                            <tr>
                                                <td colspan="12" class="text-center alert alert-info">Chưa có dữ liệu
                                                </td>
                                            </tr>
                                        @else
                                            @foreach( $product as $pro )
                                                <tr>
                                                    <td class="center"><label class="pos-rel">
                                                            <input type="checkbox" class="ace mycheckbox"
                                                                   value="{{ $pro->id }}" name="check[]">
                                                            <span class="lbl"></span> </label>
                                                    </td>
                                                    <td>{{ $pro->id }}</td>
                                                    <td>

                                                        <img src="@if(isset($pro->image['value'])){{asset($pro->image['value'])}} @endif"
                                                             height="70" width="80">

                                                    </td>
                                                    <td><strong>{{ $pro->name }}</strong></td>

                                                    <td>
                                                        @if($pro->catts && count($pro->catts))
                                                            @foreach($pro->catts as $namecat)
                                                                <span class="badge badge-dark">{{ $namecat->name }}</span> <br>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($pro->listedprice && count($pro->listedprice))
                                                            @foreach($pro->listedprice as $codec => $valuec)
                                                                <span class="badge badge-success">{{ number_format($valuec) }} {{$codec}}</span><br>
                                                            @endforeach
                                                            @endif
                                                    </td>
                                                    <td>{{ $pro->qty }}</td>
                                                    <td>
                                                        <div data-table="product" data-id="{{ $pro->is_instock }}"
                                                             data-col="is_instock"
                                                             class="Switch Round @if($pro->is_instock == 1) On @else Off @endif "
                                                             style="vertical-align:top;margin-left:10px;">
                                                            <div class="Toggle"></div>
                                                        </div>
                                                    </td>


                                                    <td>
                                                        <div data-table="product" data-id="{{ $pro->id }}"
                                                             data-col="hotdeal"
                                                             class="Switch Round @if($pro->hotdeal == 1) On @else Off @endif "
                                                             style="vertical-align:top;margin-left:10px;">
                                                            <div class="Toggle"></div>
                                                            <span class="text-muted" style="font-size: 10px">HOT</span>
                                                        </div>
                                                        <br>
                                                        <div data-table="product" data-id="{{ $pro->id }}"
                                                             data-col="bestsales"
                                                             class="Switch Round @if($pro->bestsales == 1) On @else Off @endif "
                                                             style="vertical-align:top;margin-left:10px;">
                                                            <div class="Toggle"></div>
                                                            <span class="text-muted" style="font-size: 10px">CHẠY</span>
                                                        </div>

                                                        <br>
                                                        <div data-table="product" data-id="{{ $pro->id }}"
                                                             data-col="new"
                                                             class="Switch Round @if($pro->new == 1) On @else Off @endif "
                                                             style="vertical-align:top;margin-left:10px;">
                                                            <div class="Toggle"></div>
                                                            <span class="text-muted" style="font-size: 10px">MỚI</span>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <div data-table="product" data-id="{{ $pro->id }}"
                                                             data-col="status"
                                                             class="Switch Round @if($pro->status == 1) On @else Off @endif "
                                                             style="vertical-align:top;margin-left:10px;">
                                                            <div class="Toggle"></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <a href="{{ url($backendUrl.'/product/'.$pro->id.'/edit') }}">
                                                               <span class="btn btn-warning btn-sm"> <i title="Sửa" class="ace-icon fa fa-pencil bigger-130"></i> </span></a>
                                                            <a href="#" name="{{ $pro->name }}" link="{{ url($backendUrl.'/product/'.$pro->id) }}" class="deleteClick red id-btn-dialog2" data-toggle="modal" data-target="#deleteModal">
                                                                <span class="btn btn-danger btn-sm"><i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></span></a>

                                                            {{--<a href="{{ url($backendUrl.'/product/'.$pro->id.'/attributes') }}">--}}
                                                                {{--<span class="btn btn-success btn-sm"> <i title="Sửa" class="ace-icon fa fa-list bigger-130"></i> Thuộc tính</span></a>--}}

                                                            <a href="{{ url($backendUrl.'/product/'.$pro->id.'/options') }}">
                                                                <span class="btn btn-info btn-sm"> <i title="Sửa" class="ace-icon fa fa-cogs bigger-130"></i> Tùy chọn</span></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <select name="action" class="form-control">
                                                    <option value="delete">Xóa đã chọn</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-warning"><i
                                                            class="ace-icon fa fa-check-circle bigger-130"></i> Thực
                                                    hiện
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="float-right" id="dynamic-table_paginate">
                                        <?php $product->setPath('product'); ?>
                                        <?php echo $product->render(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Delete form -->
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $(".deleteClick").click(function () {
                                var link = $(this).attr('link');
                                var name = $(this).attr('name');
                                $("#deleteForm").attr('action', link);
                                $("#deleteMes").html("Delete : " + name + " ?");
                            });
                        });
                    </script>
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    <input type="hidden" name="_method" value="delete"/>
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