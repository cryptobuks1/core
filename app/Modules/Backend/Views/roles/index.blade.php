@extends('master')

@section('css')
@endsection

@section('js')
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card">

                    <div class="card-header" style="border-bottom: 0">
                        <h3 class="card-title float-left">Danh sách</h3>
                        <div class="float-right" style="margin-right: 150px">
                            <a href="{{ url($backendUrl.'/roles/create') }}">
                                <button class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm vai trò</button>
                            </a>
                        </div>
                        <div class="card-tools ">

                            <div class="input-group input-group-sm dataTables_filter" style="width: 150px;">

                                <form action="" name="formSearch" method="GET">
                                    <input type="text" name="keyword" class="form-control float-right"
                                           placeholder="Tìm kiếm" style="padding-right: 42px;">
                                    <div class="input-group-append" style="margin-left: 110px">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <form action="{{ url($backendUrl.'/roles') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-body" style="padding-top: 0;">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="example1" class="table table-bordered table-striped dataTable">
                                        <thead>
                                        <tr>
                                            <th>Tên</th>
                                            <th>Mô tả</th>
                                            <th>Quyền</th>
                                            <th>Ngày tạo</th>
                                            <th>Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach( $roles as $role )
                                            <tr>
                                                <td>{{ $role->name }}</td>
                                                <td>{{ $role->description }}</td>
                                                <td>{{ $role->permission }}</td>
                                                <td>{{ $role->created_at }}</td>
                                                <td>
                                                    <div class="action-buttons">
                                                        @can('edit')
                                                            <a href="{{ url($backendUrl.'/roles/'.$role->id.'/edit') }}"><span
                                                                        class="btn btn-info btn-sm"> <i title="Sửa"
                                                                                                        class="ace-icon fa fa-pencil bigger-130"></i> </span></a>
                                                        @endcan
                                                        @if($role->id != 3)
                                                        @can('delete')
                                                            <a href="#" name="{{ $role->name }}"
                                                               link="{{ url($backendUrl.'/roles/'.$role->id) }}"
                                                               class="deleteClick red id-btn-dialog2"
                                                               data-toggle="modal" data-target="#deleteModal"><span
                                                                        class="btn btn-danger btn-sm"> <i title="Delete"
                                                                                                          class="ace-icon fa fa-trash-o bigger-130"></i></span></a>
                                                        @endcan
                                                            @endif

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>


                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="float-right" id="dynamic-table_paginate">
                                        <?php $roles->setPath('roles'); ?>
                                        <?php echo $roles->render(); ?>
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
                                        <h5 class="modal-title" id="exampleModalLabel">Delete Permission</h5>
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