@extends('frontend.'.$current_theme.'.app')
@section('title')
@section('customstyle')



@section('content')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card">

                    <div class="card-header" style="border-bottom: 0">
                        <h3 class="card-title">Danh sách thư mục tài liệu</h3>
                        <div class="float-right" style="margin-right: 150px">
                            <a href="{{ route('downloadcat.add') }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm danh mục</button></a>
                        </div>
                        <div class="card-tools " style="padding-bottom: 20px;">
                            <div class="input-group input-group-sm dataTables_filter" style="width: 150px; display: flex;">
                                <form action="" name="formSearch" method="GET" >
{{--                                        <input type="text" name="keyword" class="form-control float-right" placeholder="Search" style="padding-right: 42px;">--}}
{{--                                        <div class="input-group-append" style="margin-left: 110px">--}}
{{--                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>--}}
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
                                            <th>Tên danh mục</th>
                                            <th>Miêu tả</th>
                                            <th>Slug</th>
                                            <th>Nổi Bật</th>
                                            <th>Trạng thái</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data as $data_cat)
                                            <tr>
                                                <td width="20%">{{$data_cat->name}}</td>

                                                <td width="30%">{{$data_cat->description}}</td>
                                                <td>{{$data_cat->slug}}</td>
                                                <td width="10%">
                                                    @if($data_cat->featured===1)Có @else Không @endif
                                                </td>
                                                <td width="10%">@if($data_cat->status===1)Có @else Không @endif</td>
                                                <td width="10%">  <a href=""> <i title="Sửa" class="ace-icon fa fa-pencil bigger-130"></i> </a>  |
                                                    <a href="#" name="" link="" class="deleteClick red id-btn-dialog2"data-toggle="modal" data-target="#deleteModal" > <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
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





@endsection


@section('js-footer')

@endsection
