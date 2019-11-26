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

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card">

                    <div class="card-header" style="border-bottom: 0">
                        <div class="float-right" style="">
                            <div class="card-tools " style="float: left;position: relative;right: 5px;">
                                <div class="input-group input-group-sm dataTables_filter" style="">
                                    <form action="" name="formSearch" method="GET" >
                                        <div class="input-group">
                                            <select name="type" class="form-control" style="">
                                                <option value="user_id" @if(app("request")->input("type")=="user_id") selected="selected" @endif>ID khách hàng</option>
                                                <option value="phone" @if(app("request")->input("type")=="phone") selected="selected" @endif>Theo số điện thoại</option>
                                                <option value="email" @if(app("request")->input("type")=="email") selected="selected" @endif>Theo email</option>
                                                <option value="ip" @if(app("request")->input("type")=="ip") selected="selected" @endif>Theo IP</option>

                                            </select>
                                            <input type="text" name="keyword" class="form-control" placeholder="Nhập vào đây" value="{{ app("request")->input("keyword") }}" />
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->


                    <div class="card-body" style="padding-top: 0;">
                        <div class="row"><div class="col-sm-12">

                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped ">
                                        <thead>
                                        <tr>
                                            <th>TT</th>
                                            <th>Mã khách hàng</th>
                                            <th>Thông tin khách</th>
                                            <th>IP</th>
                                            <th>OTP</th>
                                            <th>User Agent</th>
                                            <th>Ngày tạo</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach( $logs as $log )
                                            <tr class="irow" data-id="{{ $log->id }}">

                                                </td>
                                                <td>{{ $log->id }}</td>
                                                <td>{{ $log->user_id }}</td>
                                                <td>{{ $log->phone }} <br></br> {{ $log->email }}</td>
                                                <td>{{ $log->ip }}</td>
                                                <td>{{ $log->twofactor }}</td>
                                                <td>{{ $log->user_agent }}</td>
                                                <td>{{ $log->created_at }}</td>



                                            </tr>
                                        @endforeach

                                        </tbody>


                                    </table>
                                </div>
                            </div></div>

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


