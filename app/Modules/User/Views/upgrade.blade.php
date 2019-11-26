@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.css') }}">
@endsection

@section('js')
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('adminlte/plugins/fastclick/fastclick.js') }}"></script>

    <script type="text/javascript">
        $(document).on('click','#action-btn',function(){
            if($('select[name="action"]').val()==='undefined' || $('select[name="action"]').val()==''){
                alert('Vui lòng chọn hành động trước khi bấm "Thực hiện".');
                return false;
            }
            if(!$('input[name="check[]"]:checked').length){
                alert('Không có mục nào được chọn.');
                return false;
            }
            $('#index-form-data').submit();
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
                        <h3 class="card-title">Danh sách thành viên</h3>
                        <div class="float-right" style="margin-right: 350px">
                            <a href="{{ url($backendUrl.'/users/create') }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Add User</button></a>
                        </div>
                        <div class="card-tools ">
                            <div class="input-group input-group-sm dataTables_filter" style="width: 350px;">
                                <form action="" name="formSearch" method="GET" >
                                    <div class="input-group">
                                        <select name="type" class="form-control" style="">
                                            <option value="">-- Search Type --</option>
                                            <option value="name" @if(app("request")->input("type")=="name") selected="selected" @endif>By Name</option>
                                            <option value="email" @if(app("request")->input("type")=="email") selected="selected" @endif>By Email</option>
                                            <option value="phone" @if(app("request")->input("type")=="phone") selected="selected" @endif>By Phone</option>
                                        <!-- <option value="status" @if(app("request")->input("type")=="status") selected="selected" @endif>By Status (0 is Inactive/1 is Active)</option> -->
                                        </select>
                                        <input type="text" name="keyword" class="form-control" placeholder="Search" value="{{ app("request")->input("keyword") }}" />
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <form id="index-form-data" action="{{ url($backendUrl.'/users/actions') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-body" style="padding-top: 0;">
                            <div class="row"><div class="col-sm-12">
                                    <table  class="table table-bordered table-striped dataTable">
                                        <thead>
                                        <tr>
                                            <th class="center sorting_disabled" rowspan="1" colspan="1" aria-label="">
                                                <label class="pos-rel">
                                                    <input type="checkbox" class="ace" id="checkall">
                                                    <span class="lbl"></span> </label>
                                            </th>
                                            <th>ID</th>
                                            <th>Họ tên</th>
                                            <th>Email</th>
                                            <th>Điện thoại</th>
                                            <th>Số dư</th>
                                            <th>Nhóm</th>
                                            <th>Quyền</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach( $users as $user )
                                            <tr>
                                                <td class="center"><label class="pos-rel">
                                                        <input type="checkbox" class="ace mycheckbox" value="{{ $user->id }}" name="check[]">
                                                        <span class="lbl"></span> </label>
                                                </td>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>
                                                    @if(isset($sodu[$user->id]))
                                                        @foreach($sodu[$user->id] as $cur => $value)
                                                            <span class="text-danger" style="display:block">{{ number_format($value) }} {{ $cur }}</span>
                                                        @endforeach
                                                    @endif
                                                </td>

                                                <td>{{ $user->getGroupName($user->group)  }}</td>
                                                <td>
                                                    @if(!empty($user->getRoleNames()))
                                                        @foreach($user->getRoleNames() as $v)
                                                            <label class="badge badge-success">{{ $v }}</label>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    <div data-table="users" data-id="{{ $user->id }}" data-col="status" class="Switch Round @if($user->status == 1) On @else Off @endif" style="vertical-align:top;margin-left:10px;">
                                                        <div class="Toggle" ></div>
                                                    </div>
                                                </td>
                                                <td>{{ $user->created_at }}</td>
                                                <td>
                                                    <div class="action-buttons">

                                                        <a href="{{ url($backendUrl.'/admin/'.$user->id.'/upgradeUser') }}"> <i title="Sửa" class="fa fa-cog"></i> </a>


                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>


                                    </table>
                                </div></div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <select name="action" class="form-control">
                                                    <option value=''></option>
                                                    <option value="delete">Xóa đã chọn</option>
                                                    <!-- <option value="delete">Khóa tài khoản</option>
                                                    <option value="delete">Mở khóa tài khoản</option> -->
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" id="action-btn" class="btn btn-warning"><i class="ace-icon fa fa-check-circle bigger-130"></i> Thực hiện</button>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="float-right" id="dynamic-table_paginate">
                                        <?php $users->setPath('users'); ?>
                                        <?php echo $users->render(); ?>
                                    </div>
                                </div>
                            </div>
                        </div></form>

                    <!-- Delete form -->
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
                                        <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
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
