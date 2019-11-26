@extends('master')

@section('css')
@endsection

@section('js')
    <script type="text/javascript">
        $(document).on('click', '#action-btn', function () {
            if ($('select[name="action"]').val() === 'undefined' || $('select[name="action"]').val() == '') {
                alert('Vui lòng chọn hành động trước khi bấm "Thực hiện".');
                return false;
            }
            if (!$('input[name="check[]"]:checked').length) {
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
                        <div class="float-right">
                        <div class="card-tools ">
                            <div class="input-group input-group-sm dataTables_filter" >

                                <div class="float-left">
                                    <a href="{{ url($backendUrl.'/users/create') }}">
                                        <button class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm
                                        </button>
                                    </a>
                                </div>

                                <form action="" name="formSearch" method="GET">
                                    <div class="input-group">
                                        <select name="group_user" class="form-control" style="">
                                            <option value=""
                                                    @if(app("request")->input("group_user")== "") selected="selected" @endif>
                                                Nhóm khách hàng
                                            </option>
                                            @if($group_user && count($group_user) > 0)
                                                @foreach($group_user as $group)
                                                    <option value="{{$group->id}}"
                                                            @if(app("request")->input("group_user")== $group->id) selected="selected" @endif>{{$group->name}}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                        <select name="status" class="form-control" style="">
                                            <option value="">-- Trạng thái --</option>
                                            <option value="status0"
                                                    @if(app("request")->input("status")=="status0") selected="selected" @endif>
                                                Trạng thái khóa
                                            </option>
                                            <option value="status1"
                                                    @if(app("request")->input("status")=="status1") selected="selected" @endif>
                                                Trạng thái mở
                                            </option>
                                        </select>
                                        <select name="type" class="form-control" style="">
                                            <option value="">-- Loại tìm kiếm --</option>
                                            <option value="id"
                                                    @if(app("request")->input("type")=="id") selected="selected" @endif>
                                                Theo ID
                                            </option>
                                            <option value="username"
                                                    @if(app("request")->input("type")=="username") selected="selected" @endif>
                                                Username
                                            </option>
                                            <option value="name"
                                                    @if(app("request")->input("type")=="name") selected="selected" @endif>
                                                Theo họ tên
                                            </option>
                                            <option value="email"
                                                    @if(app("request")->input("type")=="email") selected="selected" @endif>
                                                Theo Email
                                            </option>
                                            <option value="phone"
                                                    @if(app("request")->input("type")=="phone") selected="selected" @endif>
                                                The số điện thoại
                                            </option>
                                        </select>
                                        <input type="text" name="keyword" class="form-control" placeholder="Search"
                                               value="{{ app("request")->input("keyword") }}"/>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <form id="index-form-data" action="{{ url($backendUrl.'/users/actions') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-body" style="padding-top: 0;">
                            <div class="row">
                                <div class="col-sm-12 table-responsive">
                                    <table class="table table-bordered table-striped dataTable">
                                        <thead>
                                        <tr>
                                            <th class="center sorting_disabled" rowspan="1" colspan="1" aria-label="">
                                                <label class="pos-rel">
                                                    <input type="checkbox" class="ace" id="checkall">
                                                    <span class="lbl"></span> </label>
                                            </th>
                                            <th>ID</th>
                                            <th>Họ tên</th>
                                            <th>Thông tin</th>
                                            <th>Số dư</th>
                                            <th>Nhóm</th>
                                            <th>Vai trò</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th>Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach( $users as $user )
                                            <tr>
                                                <td class="center"><label class="pos-rel">
                                                        <input type="checkbox" class="ace mycheckbox"
                                                               value="{{ $user->id }}" name="check[]">
                                                        <span class="lbl"></span> </label>
                                                </td>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>@if($user->username) <i class="ace-icon fa fa-user bigger-130"></i> <strong>{{ $user->username }}</strong> <br>@endif
                                                    @if($user->email) <i class="ace-icon fa fa-envelope bigger-130"></i> <strong class="text-dark">{{ $user->email }}</strong> <span class="text-success">@if($user->verify_email == 1)<i class="ace-icon fa fa-check-circle"></i></span> @endif <br> @endif
                                                    @if($user->phone) <i class="ace-icon fa fa-phone bigger-130"></i> <strong class="text-info">{{ $user->phone }}</strong>  <span class="text-success">@if($user->verify_email == 1)<i class="ace-icon fa fa-check-circle"></i></span> @endif @endif
                                                </td>
                                                <td>
                                                    @if(count($user->wallets)> 0)
                                                        @foreach($user->wallets as $wallet)
                                                            <span class="text-danger" style="display:block"><i class="ace-icon fa fa-money"></i> {{ number_format($wallet->balance_decode) }} {{ $wallet->currency_code }}</span><br>
                                                        @endforeach
                                                    @endif
                                                </td>

                                                <td>{{ $user->getGroupName($user->group)  }}</td>
                                                <td>
                                                    @if(count($user->getRoleNames()) > 0)
                                                        @foreach($user->getRoleNames() as $v)
                                                            <label class="badge badge-success">{{ $v }}</label>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($user->id !== 1)
                                                    <div data-table="users" data-id="{{ $user->id }}" data-col="status"
                                                         class="Switch Round @if($user->status == 1) On @else Off @endif"
                                                         style="vertical-align:top;margin-left:10px;">
                                                        <div class="Toggle"></div>
                                                    </div>
                                                    @endif
                                                </td>
                                                <td>{{ $user->created_at }}</td>
                                                <td>
                                                    <div class="action-buttons">

                                                        <a href="{{ url($backendUrl.'/users/'.$user->id.'/edit') }}" title="Sửa"> <span class="btn btn-sm btn-info"><i class="ace-icon fa fa-pencil bigger-130"></i></span></a>
                                                        @if($user->id !== 1)
                                                        <a href="#" name="{{ $user->name }}" link="{{ url($backendUrl.'/users/'.$user->id) }}"  title="Xóa" class="deleteClick red id-btn-dialog2" data-toggle="modal" data-target="#deleteModal"><span class="btn btn-sm btn-danger"><i class="ace-icon fa fa-trash-o bigger-130"></i></span></a>
                                                        <a href="{{ url('/userlogin/'.$user->id.'/'.$user->token) }}" title="Đăng nhập vào tài khoản thành viên"><span class="btn btn-sm btn-warning"><i class="ace-icon fa fa-sign-in bigger-130"></i></span></a>
                                                        @endif
                                                        <a href="{{ url($backendUrl.'/wallets?type=user_id&keyword='.$user->id) }}" title="Nạp rút tiền"> <span class="btn btn-sm btn-success"><i class="ace-icon fa fa-dollar bigger-130"></i> Nạp rút</span></a>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
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
                                                    <option value=''></option>
                                                    <option value="delete">Xóa đã chọn</option>
                                                    <!-- <option value="delete">Khóa tài khoản</option>
                                                    <option value="delete">Mở khóa tài khoản</option> -->
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" id="action-btn" class="btn btn-warning"><i
                                                            class="ace-icon fa fa-check-circle bigger-130"></i> Thực
                                                    hiện
                                                </button>
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
                                        <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
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