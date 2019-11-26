@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
@endsection

@section('js')
    @include('ckfinder::setup')
    <script src="{{ asset('adminlte/plugins/ckeditor4101/ckeditor.js') }}"></script>
    <script>
        $(function () {
            CKEDITOR.replace('description', {
                filebrowserBrowseUrl: '{{ url('adminnc/ckfinderpopup') }}',
                filebrowserImageBrowseUrl: '{{ url('adminnc/ckfinderpopup') }}',
                filebrowserFlashBrowseUrl: '{{ url('adminnc/ckfinderpopup') }}',
            });
            CKEDITOR.config.extraPlugins = 'justify';
        });
    </script>
    <script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2()
        });
    </script>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card-header" style="border-bottom: 0">
            <h3 class="card-title">Các tùy chọn</h3>
            <div class="float-right" style="margin-right: 350px">
                <a href="{{ route('backend.product.options',$product->id) }}">
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
        <div class="row">
            <div class="col-md-5">
                <div class="card card-light">
                    <div class="card-header">
                        <h3 class="card-title">Chỉnh sửa tùy chọn cho sản phẩm</h3>
                    </div>

                    @include('layouts.errors')

                    {!! Form::model($optionitem, ['method' => 'PATCH','route' => ['backend.product.optionvalue.update',$optionitem->id],'enctype'=>'multipart/form-data']) !!}
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Tên tùy chọn:</label>
                                <input class="form-control" value="{{$optionitem->name}}" name="name" id="name">
                            </div>
                            <div class="form-group">
                                <label for="product_sku">SKU của tùy chọn:</label>
                                <div class="form-row">
                                    <div class="col-4">
                                        <input class="form-control" value="{{$optionitem->sku}}" readonly>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="product_id">Sản phẩm:</label>
                                <input class="form-control" value="{{$product->name}}" readonly>
                                <input type="hidden" class="form-control" value="{{$product->id}}" name="product_id" readonly>
                            </div>
                            <div class="form-group">
                                <label for="option">Loại tùy chọn:</label>
                                <select class="form-control" name="option">
                                    @if(count($options) > 0)
                                        @foreach($options as $option)
                                            <option value="{{$option->id}}" @if($option->id == $optionitem->option_id) selected @endif>{{$option->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="lang">Ngôn ngữ:</label>
                                <select class="form-control" name="lang">
                                    @if(count($langs) > 0)
                                        @foreach($langs as $lang)
                                            <option value="{{$lang->code}}" @if($lang->code == $optionitem->lang) selected @endif>{{$lang->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="sort">Sắp xếp:</label>
                                <input class="form-control" value="{{$optionitem->sort_order}}" name="sort_order" type="number" id="sort">
                            </div>
                            <div class="form-group">
                                <label for="status" style="width: 100%">Số tiền điều chỉnh giá bán:</label>
                                <span class="text-muted">Lưu ý: nhập số dương nếu muốn thêm, số âm nếu muốn bớt. ví dụ: -2000</span>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        @if($groups->count())
                                            @foreach( $groups as $group )
                                                <th>{{ $group->name }}</th>
                                            @endforeach
                                        @endif

                                    </tr>

                                    </thead>
                                    <tbody>
                                    @if(count($currencies))
                                        @foreach($currencies as $cur)
                                            <tr>
                                                <td><strong>{{$cur->code}}</strong></td>
                                                @foreach($groups as $group)
                                                    <td>
                                                        <input name="price[{{$cur->code}}][{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                               value="{{$optionitem->price[$cur->code][$group->id]}}">
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>


                            </div>



                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-md-7">

                <div class="card card-light">
                    <div class="card-header">
                        <h3 class="card-title">Loại tùy chọn</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped dataTable">
                            <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Tên</th>
                                <th>Giá (Guest)</th>
                                <th>Loại</th>
                                <th>Ngôn ngữ</th>
                                <th>Trạng thái</th>
                                <th>Sắp xếp</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!count($opvalues))
                                <tr>
                                    <td colspan="12" class="text-center alert alert-info">Chưa có dữ liệu
                                    </td>
                                </tr>
                            @else
                                @foreach( $opvalues as $opvalue )
                                    <tr>
                                        <td>{{ $opvalue->sku }}</td>
                                        <td><strong>{{ $opvalue->name }}</strong></td>
                                        <td>

                                            @if($opvalue->price && count($opvalue->price))
                                                @foreach($opvalue->price as $codec => $valuec)
                                                    <span class="badge badge-success">{{ number_format($valuec[1], 2) }} {{$codec}}</span><br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ $opvalue->option_name }}</td>

                                        <td>{{ $opvalue->lang }}</td>
                                        <td>
                                            <div data-table="product_option_value" data-id="{{ $opvalue->id }}"
                                                 data-col="status"
                                                 class="Switch Round @if($opvalue->status == 1) On @else Off @endif "
                                                 style="vertical-align:top;margin-left:10px;">
                                                <div class="Toggle"></div>
                                            </div>
                                        </td>
                                        <td>{{ $opvalue->sort }}</td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ url($backendUrl.'/product/'.$opvalue->id.'/option/value/edit') }}">
                                                    <span class="btn btn-warning btn-sm"> <i title="Sửa" class="ace-icon fa fa-pencil bigger-130"></i> </span></a>
                                                <a href="#" name="{{ $opvalue->name }}"
                                                   link="{{ url($backendUrl.'/product/'.$opvalue->id).'/option/value/delete' }}" class="deleteClick red id-btn-dialog2" data-toggle="modal" data-target="#deleteModal">
                                                    <span class="btn btn-danger btn-sm"><i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></span></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="col-sm-12">
                            <div class="float-right" id="dynamic-table_paginate">
                                {!! $options->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    </section>
@endsection